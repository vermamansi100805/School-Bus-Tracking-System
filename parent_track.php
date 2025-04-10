<?php 
// Include the database connection file
include("config.php");
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get roll number and bus number from the form
    $roll_no = trim($_POST['roll_no']);
    $bus_no = trim($_POST['bus_no']);

    if ($conn) {
        // ✅ Step 1: Check if roll number and bus number match in parent_login table
        $sql = "SELECT roll_no, bus_no FROM parent_login WHERE roll_no = ? AND bus_no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $roll_no, $bus_no);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // ✅ Step 2: Check bus status from driver_login table
            $statusQuery = "SELECT status FROM driver_login WHERE bus_no = ?";
            $statusStmt = $conn->prepare($statusQuery);
            $statusStmt->bind_param("s", $bus_no);
            $statusStmt->execute();
            $statusResult = $statusStmt->get_result();

            if ($statusResult->num_rows > 0) {
                $row = $statusResult->fetch_assoc();

                // ✅ Step 3: If bus is active, redirect to tracking page
                if ($row['status'] === 'active') {
                    if ($bus_no == "102") {
                        header("Location:map.html");
                        exit();
                    } else {
                        $message = "Bus tracking for this number is not available!";
                    }
                } else {
                    // ❌ If bus is inactive, show message
                    $message = "This bus is currently not running!";
                }
            } else {
                $message = "Bus number not found!";
            }

            $statusStmt->close();
        } else {
            $message = "Invalid Roll No or Bus No!";
        }
        $stmt->close();
    } else {
        $message = "Database connection error!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Tracking</title>

    <!-- ✅ Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f8f9fa;
        }
        .navbar {
            width: 100%;
            background-color: #007bff;
            padding: 1rem;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            margin-top: 60px;
        }
        .card-title {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            transition: 0.3s;
        }
        input[type="text"]:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
        }
        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }
        button:hover {
            background: #218838;
            transform: scale(1.05);
        }
        .message {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<!-- ✅ Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="#">🚍 School Bus Tracking System</a>
        <a class="navbar-brand text-white" href="parent_dashboard.php">Back</a>
    </div>
</nav>

<!-- ✅ Tracking Form -->
<div class="container">
    <h2 class="card-title">Track Location</h2>
    <form method="POST">
        <input type="text" name="roll_no" placeholder="Enter Roll No" required>
        <input type="text" name="bus_no" placeholder="Enter Bus Number" required>
        <button type="submit">Submit</button>
    </form>
    <p class="message"><?php echo $message; ?></p>
</div>

<!-- ✅ Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
