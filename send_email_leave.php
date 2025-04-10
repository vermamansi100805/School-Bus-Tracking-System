<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // If using Composer
include 'config.php';

$data = json_decode(file_get_contents("php://input"));
$bus_no = $data->bus_no;

// ✅ Fetch student emails based on bus number
$query = "SELECT student_name, email FROM parent_login WHERE bus_no = '$bus_no'";
$result = mysqli_query($conn, $query);

$messages = [];

while ($row = mysqli_fetch_assoc($result)) {
    $email = $row['email'];
    $student_name = $row['student_name'];

    $subject = "Bus Notification - Driver is Not Coming";
    $body = "Hello $student_name, <br><br>The driver for bus no. $bus_no will not be coming today.<br> Please make alternate arrangements.";

    if (sendEmail($email, $subject, $body)) {
        $messages[] = "Email sent to $email";
    } else {
        $messages[] = "Failed to send email to $email";
    }
}

// ✅ Send JSON response back to JavaScript
echo json_encode(["message" => implode("\n", $messages)]);

function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '';//email id
        $mail->Password = ''; // Use your app password here
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
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
