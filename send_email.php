<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // For PHPMailer
include 'config.php'; // Connect to MySQL Database

// Get input data from the request
$data = json_decode(file_get_contents("php://input"), true);
$bus_stop = $data['bus_stop'];
$bus_no = (int) $data['bus_no'];

if (!$bus_stop || !$bus_no) {
    echo json_encode(["status" => "error", "message" => "Invalid input data"]);
    exit;
}

// ✅ Fetch students waiting at this stop
$query = "SELECT student_name, email FROM parent_login WHERE bus_stop = ? AND bus_no = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $bus_stop, $bus_no);
$stmt->execute();
$result = $stmt->get_result();

$messages =" ";

while ($row = $result->fetch_assoc()) {
    $email = $row['email'];
    $student_name = $row['student_name'];

    $subject = "Bus Arrival Notification";
    $body = "
        <p>Hello <b>$student_name</b>,</p>
        <p>Your bus (Bus No. <b>$bus_no</b>) has arrived at <b>$bus_stop</b>. 
        <br>Please proceed to board the bus.</p>
        <p>Thank you!<br><b>Bus Tracking System</b></p>
    ";

    if (sendEmail($email, $subject, $body)) {
        $messages= "Email sent to $email";
    } else {
        $messages= "Failed to send email to $email";
    }
}

// ✅ Save Bus Location
$stops = [
    ["name" => "Mulund Railway Station (West)", "lat" => 19.172493734949025, "lng" => 72.95616566560044],
    ["name" => "Ambaji Dham", "lat" => 19.178820571160976, "lng" => 72.94895764444415],
    ["name" => "E.S.I.S Hospital", "lat" => 19.178676553579688, "lng" => 72.94498979990995],
    ["name" => "Veena Nagar", "lat" => 19.182122272352903, "lng" => 72.94706828882978],
    ["name" => "Santoshi Mata Mandir (Mulund W)", "lat" => 19.18328117982267, "lng" => 72.94832348499398],
    ["name" => "R Mall, Mulund", "lat" => 19.183676258231596, "lng" => 72.95208405642035],
    ["name" => "Maharana Pratap Chowk", "lat" => 19.184244760305088, "lng" => 72.95380620919433],
    ["name" => "LBS Marg", "lat" => 19.184869027565096, "lng" => 72.9550116180224],
    ["name" => "Check naka", "lat" => 19.185474467428204, "lng" => 72.95576465887197],
    ["name" => "Automatic Company", "lat" => 19.187176753314446, "lng" => 72.95534730094457],
    ["name" => "MIDC", "lat" => 19.190317107739872, "lng" => 72.95552099792444],
    ["name" => "Road No 12", "lat" => 19.192467107093474, "lng" => 72.9551356108609],
    ["name" => "Road Number 16", "lat" => 19.193810123615314, "lng" => 72.95363597192922],
    ["name" => "Dwarka hotel", "lat" => 19.194601173359036, "lng" => 72.95105630486597],
    ["name" => "22 Circle", "lat" => 19.19473465197042, "lng" => 72.94923709217157],
    ["name" => "Sathe nagar", "lat" => 19.201024253219344, "lng" => 72.94904346612762],
    ["name" => "Indira nagar", "lat" => 19.20503526516572, "lng" => 72.95002481263808],
    ["name" => "Sawarkar nagar", "lat" => 19.207327809492835, "lng" => 72.95063547797781],
    ["name" => "Lokmanya Nagar (Thane)", "lat" => 19.20938340143996, "lng" => 72.95175942558431],
];

$lat = 0;
$lng = 0;

foreach ($stops as $stop) {
    if ($stop['name'] == $bus_stop) {
        $lat = $stop['lat'];
        $lng = $stop['lng'];
        break;
    }
}

if ($lat != 0 && $lng != 0) {
    $sql = "INSERT INTO bus_locations (bus_no, latitude, longitude) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idd", $bus_no, $lat, $lng);

    if ($stmt->execute()) {
        $messages= "Location saved successfully";
    } else {
        $messages= "Error saving location: " . $stmt->error;
    }
    $stmt->close();
} else {
    $messages= "Bus stop not found in stops list.";
}

// ✅ Return response
echo json_encode(["status" => "success", "messages" => $messages]);

// ✅ Function to Send Email via Gmail SMTP
function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        // **SMTP Configuration**
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = ''; // Your Gmail address
        $mail->Password = ''; // Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // **Email Headers**
        $mail->setFrom('', 'Bus Tracking System');//enter email
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>