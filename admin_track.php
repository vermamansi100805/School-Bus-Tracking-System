<?php 
include("config.php");
error_reporting(0);
session_start();
$error = "";

if (isset($_POST['submit'])) {
    date_default_timezone_set('Asia/Kolkata');
    
    $bnum = trim($_POST['bus_no']);

    // Prevent empty input
    if (empty($bnum)) {
        $error = "Please enter a bus number";
    } else {
        // Use Prepared Statement to prevent SQL Injection
        $stmt = $conn->prepare("SELECT * FROM driver_login WHERE bus_no = ? AND status = 'active'");
        $stmt->bind_param("s", $bnum);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if (!$result) {
            die("Query failed: " . $conn->error);
        }

        if ($result->num_rows > 0) {
            // Bus redirection mapping
            $bus_routes = [
                '102' => 'map.html',
            ];

            if (isset($bus_routes[$bnum])) {
                header("Location: " . $bus_routes[$bnum]);
                exit();
            } else {
                $error = "Invalid Bus Number"; 
            }
        } else {
            $error = "This bus is currently not running";
        }

        $stmt->close(); // Close statement
    }
}
?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Bus Tracking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        
        /* Navbar styles */
        .navbar {
            background-color: #007bff;
            padding: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-weight: bold;
        }
        
        /* Centering container */
        .center-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            max-width: 400px;
            width: 100%;
            padding: 20px;
        }
        
        .btn-custom {
            width: 100%;
            background-color: #28a745;
            color: white;
            font-weight: bold;
        }
        
        .btn-custom:hover {
            background-color: #218838;
        }
        
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
        
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">School Bus Tracking System</a>
            <a class="navbar-brand text-white" href="admin_dashboard.php">Back</a>
        </div>
    </nav>

    <!-- Centered Content -->
    <div class="center-container">
        <div class="card">
            <h4 class="text-center">Track Location</h4>

            <form method="POST">
                <div class="form-group">
                    <label for="bus_no">Bus No.</label>
                    <input type="text" class="form-control" id="bus_no" name="bus_no" placeholder="Enter Bus No." required>
                </div>

                <button type="submit" name="submit" class="btn btn-custom">Submit</button>

                <?php if (!empty($error)): ?>
                    <p class="error-message text-center"><?php echo $error; ?></p>
                <?php endif; ?>
            </form>
        </div>
    </div>
    

    
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
