<?php 
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize input
    $roll_no = intval($_POST['RollNo']); // Convert to integer
    $student_name = trim($_POST['studentName']);
    $email = trim($_POST['email']);
    $Password = $_POST['Password']; // Store password in plaintext
    $contact_number = trim($_POST['contactNumber']);
    $home_address = trim($_POST['homeAddress']);
    $bus_stop = trim($_POST['busStop']);
    $bus_no = intval($_POST['busNo']); // Convert to integer
    $student_class = intval($_POST['studentClass']); // Convert to integer

    // Prepare SQL statement (Ensure correct column and value count)
    $sql = "INSERT INTO parent_login (roll_no, student_name, email, Password, contact_number, home_address, bus_stop, bus_no, class) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL error: " . $conn->error); // Display SQL error for debugging
    }

    // Bind parameters (Ensure correct data types)
    $stmt->bind_param("issssssis", $roll_no, $student_name, $email, $Password, $contact_number, $home_address, $bus_stop, $bus_no, $student_class);

    // Execute statement and check success
    if ($stmt->execute()) {
        echo "<script>alert('Student registered successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    // Close statement & database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
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
            <h2 class="text-center">Student Registration</h2>
            <form method="POST" action="">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="RollNo" class="form-label">Roll No.</label>
                        <input type="number" class="form-control" id="RollNo" name="RollNo" placeholder="Enter Student Roll No." required>
                    </div>
                    <div class="col-md-6">
                        <label for="studentName" class="form-label">Student Name</label>
                        <input type="text" class="form-control" id="studentName" name="studentName" placeholder="Enter Student Name" required>
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
                        <label for="homeAddress" class="form-label">Home Address</label>
                        <input type="text" class="form-control" id="homeAddress" name="homeAddress" placeholder="Enter Home Address" required>
                    </div>
                    <div class="col-md-6">
                        <label for="busStop" class="form-label">Bus Stop</label>
                        <input type="text" class="form-control" id="busStop" name="busStop" placeholder="Enter Bus Stop" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="studentClass" class="form-label">Class</label>
                        <input type="number" class="form-control" id="studentClass" name="studentClass" placeholder="Enter Student Class" required>
                    </div>
                    <div class="col-md-6">
                        <label for="busNo" class="form-label">Bus No</label>
                        <input type="number" class="form-control" id="busNo" name="busNo" placeholder="Enter Bus Number" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="Password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="Password" name="Password" placeholder="Enter Password" required>
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
