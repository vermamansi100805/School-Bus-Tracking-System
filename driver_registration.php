<?php
$servername = "localhost"; // Change if needed
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$database = "project"; // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
$successMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $busNo = $_POST["busNo"];
    $driverName = $_POST["driverName"];
    $email = $_POST["email"];
    $contactNumber = $_POST["contactNumber"];
    $password = $_POST["password"]; // Storing password in plaintext
    $homeAddress = $_POST["homeAddress"];

    // Insert query
    $sql = "INSERT INTO driver_login (bus_no, driver_name, email, contact_number, password, home_address) 
            VALUES ('$busNo', '$driverName', '$email', '$contactNumber', '$password', '$homeAddress')";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "Form submitted successfully!";
    } else {
        $successMessage = "Error: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .form-control {
            border-radius: 10px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-family: 'Arial', sans-serif;
            color: #007bff;
        }
        .btn-custom {
            font-size: 14px;
            padding: 7px 20px;
            border-radius: 20px;
        }
        .card-body {
            padding: 30px;
        }
        .alert {
            display: <?= $successMessage ? 'block' : 'none' ?>;
        }
        .footer {
            background-color: #f8f9fa;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
            border-top: 1px solid #ddd;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }     
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card p-4">
            <h2 class="text-center">Driver Registration</h2>
            <?php if ($successMessage): ?>
                <div class="alert alert-success"><?= $successMessage ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="busNo" class="form-label">Bus No.</label>
                        <input type="text" class="form-control" id="busNo" name="busNo" placeholder="Enter Driver Bus No." required>
                    </div>
                    <div class="col-md-6">
                        <label for="driverName" class="form-label">Driver Name</label>
                        <input type="text" class="form-control" id="driverName" name="driverName" placeholder="Enter Driver Name" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email Id</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="col-md-6">
                        <label for="contactNumber" class="form-label">Contact Number</label>
                        <input type="tel" class="form-control" id="contactNumber" name="contactNumber" placeholder="Enter Contact Number" required pattern="\d{10}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <div class="col-md-6">
                        <label for="homeAddress" class="form-label">Home Address</label>
                        <input type="text" class="form-control" id="homeAddress" name="homeAddress" placeholder="Enter Home Address" required>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-custom">Submit</button>
                </div>                               
            </form>
        </div>
    </div>
    <div class="footer">
        <p>Go Back <a href="admin_dashboard.php">To Dashboard</a></p>
    </div>
</body>
</html>
