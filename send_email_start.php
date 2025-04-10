<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include 'config.php';

$data = json_decode(file_get_contents("php://input"), true);
$bus_no = (int) $data['bus_no'];

$query = "SELECT email, student_name FROM parent_login WHERE bus_no = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $bus_no);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $to = $row['email'];
    $student_name = $row['student_name'];

    $subject = "Bus Notification - Bus Started";
    $body = "Hello $student_name,<br><br>Your bus (Bus No. $bus_no) has started from <b>Mulund Railway Station (West)</b>.";

    sendEmail($to, $subject, $body);
}

function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '';//enter email
        $mail->Password = '';//enter google app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('', 'Bus Tracking System');//enter email id
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->send();
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}
?>
