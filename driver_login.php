<?php
session_start();
require_once 'config.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM driver_login WHERE email = ? AND Password = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $error = "Database error: " . $conn->error;
    } else {
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $driver = $result->fetch_assoc();
            $_SESSION['user_type'] = 'driver';
            $_SESSION['email'] = $driver['email'];
            $_SESSION['driver_name'] = $driver['driver_name']; // ✅ Correct case
            $_SESSION['bus_no'] = $driver['bus_no']; // ✅ Correct case
            $_SESSION['driver_id'] = $driver['id']; // ✅ Store driver ID

            header("Location: driver_dashboard.php");
            exit();
        } else {
            $error = "Invalid credentials!";
        }
        
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Driver Login</h2>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <a href="forgot_password_driver.php" class="text-decoration-none">Forgot Password?</a>
                        </div>
                        <div class="text-center mt-3">
                            <a href="login.html" class="text-decoration-none">Back to User Selection</a>
                        </div>
                        <div class="footer">
                            <p>Need help? <a href="contact.html">Contact us</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>