<?php
include("config.php");
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $driver_name = trim($_POST['driver_name']);
    $bus_no = trim($_POST['bus_no']);

    if ($conn) {
        $sql = "SELECT status FROM driver_login WHERE driver_name = ? AND bus_no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $driver_name, $bus_no);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($status);
            $stmt->fetch();

            if ($status == "inactive") {
                $message = "🚫 This bus is not running.";
            } else {
                if ($bus_no == "102") {
                    header("Location: 102track.html");
                    exit();
                }  else {
                    $message = "❌ Invalid bus number.";
                }
            }
        } else {
            $message = "⚠️ Invalid driver name or bus number.";
        }
        $stmt->close();
    } else {
        $message = "❗ Database connection error.";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Tracking</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #ffffff; /* Removed background color */
        }
        .navbar {
            width: 100%;
            background-color: #007bff;
            padding: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .container {
             background: white;
             padding: 20px;
             border-radius: 12px;
             box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
             max-width: 350px;
            min-height: 350px; /* Increased height */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .card-title {
            font-size: 22px;
            font-weight: bold;
            color: #007bff;
        }
        input {
        width: 100%;
        padding: 10px;
        margin: 15px 0; /* Increased gap */
        border-radius: 5px;
        border: 1px solid #ccc;
        transition: 0.3s;
    }

        input:focus {
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
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">🚍 School Bus Tracking System</a>
            <a class="navbar-brand text-white" href="driver_dashboard.php">Back</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="card-title">Track Location</h2>
        <form method="POST">
            <input type="text" name="driver_name" placeholder="Enter Driver Name" required>
            <input type="text" name="bus_no" placeholder="Enter Bus Number" required>
            <button type="submit">Submit</button>
        </form>
        <p class="message"><?php echo $message; ?></p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
