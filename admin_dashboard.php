<?php 
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Navbar styles */
        .navbar {
            background-color: #007bff;
            padding: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .nav-item a {
            color: white;
            font-weight: bold;
            text-decoration: none;
            padding: 0.5rem 1rem;
        }

        .nav-item a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }

        .dropdown-menu a {
            color: #333;
        }

        .dropdown-menu a:hover {
            background-color: #007bff;
            color: white;
        }

        /* Card styles */
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            margin: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card img {
            height: 350px;
            object-fit: cover;
        }

        .card h3 {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card p {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="#">School Bus Tracking System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- ✅ Bus Dropdown with Options -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Bus</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="admin_track.php" >Track location </a></li>
                        <li><a class="dropdown-item" href="bus_stops_name.html">Bus Stop Names</a></li>
                    </ul>
                </li>
                <!-- ✅ Driver Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Driver</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="driver_registration.php">Add Driver</a></li>
                        <li><a class="dropdown-item" href="driver_viewing.php">View Driver</a></li>
                    </ul>
                </li>
                <!-- ✅ Parent Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Parent</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="student_registration.php">Add Students</a></li>
                        <li><a class="dropdown-item" href="student_viewing.php">View Students</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="logout()">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- ✅ Content Section -->
<div class="container">
    <div class="row">
        <!-- ✅ Bus Location -->
        <div class="col-md-4">
            <div class="card">
                <img src="image/buslocation.png" alt="Bus Location">
                <div class="card-body">
                    <h3>Bus Location and History</h3>
                    <p>A school bus tracking system provides real-time tracking of bus locations, estimates ETAs, and maintains detailed history.</p>
                </div>
            </div>
        </div>

        <!-- ✅ Driver Management -->
        <div class="col-md-4">
            <div class="card">
                <img src="image/adddriver.png" alt="Add Driver">
                <div class="card-body">
                    <h3>Driver Management</h3>
                    <p>Efficiently manage drivers, including adding new drivers, viewing their assigned routes, and tracking performance.</p>
                </div>
            </div>
        </div>

        <!-- ✅ Student Management -->
        <div class="col-md-4">
            <div class="card">
                <img src="image/addstudent.png" alt="Add Student">
                <div class="card-body">
                    <h3>Student Management</h3>
                    <p>Manage student records, contacts, and assigned bus numbers easily and efficiently.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ JavaScript -->
<script>
    // ✅ Function to Logout
    function logout() {
        alert('You have been logged out.');
        window.location.href = "login.html";
    }
</script>

<!-- ✅ Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
