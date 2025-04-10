<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $new_password = trim($_POST['new_password']);

    // Find the email associated with the token
    $sql = "SELECT email FROM password_resets WHERE token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $email = $row['email'];

        // Store the password in plain text (NOT recommended for security reasons)
        $update_sql = "UPDATE parent_login SET Password = ? WHERE email = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ss", $new_password, $email);
        
        if ($update_stmt->execute()) {
            echo "<script>alert('Password reset successful. You can now login.'); window.location.href='parent_login.php';</script>";
            
            // Delete the token after reset
            $delete_sql = "DELETE FROM password_resets WHERE email = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("s", $email);
            $delete_stmt->execute();
        } else {
            echo "Error updating password.";
        }
    } else {
        echo "Invalid or expired token.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Reset Password</h2>
                        <form method="POST" action="">
                            <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="text" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Reset Password</button>
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
</body>
</html>
