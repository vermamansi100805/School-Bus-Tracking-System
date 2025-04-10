<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require_once 'config.php'; // Database connection

$message = ''; // ✅ Initialize the message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if email exists in the database
    $sql = "SELECT * FROM parent_login WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Generate a password reset token
        $token = bin2hex(random_bytes(32)); // Secure token
        $reset_link = "http://localhost/project/reset_password_parent.php?token=" . $token;

        // Store the token in the password_resets table
        $stmt = $conn->prepare("INSERT INTO password_resets (email, token) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $token);
        $stmt->execute();

        // Send email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = ''; // ✅ Your email
            $mail->Password = ''; // ✅ Your Google App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('', 'Support'); // ✅ Correct email id enter
            $mail->addAddress($email);

            $mail->Subject = "Password Reset Request";
            $mail->Body = "Click the link below to reset your password:\n\n$reset_link";

            $mail->send();
            $message = "Password reset link has been sent to your email.";
        } catch (Exception $e) {
            $message = "Email could not be sent. Error: {$mail->ErrorInfo}";
        }
    } else {
        $message = "Email not found in our records.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Forgot Password</h2>
                        
                        <?php if (!empty($message)): ?>
                            <div class="alert alert-info"><?php echo $message; ?></div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="email" class="form-label">Enter your registered email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Send Reset Link</button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <a href="parent_login.php" class="text-decoration-none">Back to Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
