<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(120deg, #fdfbfb, #ebedee);
            min-height: 100vh;
        }

        .navbar {
            background-color: #007bff;
            padding: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-nav .nav-link {
            color: white;
            font-weight: bold;
            padding: 0.5rem 1rem;
            transition: background-color 0.3s ease-in-out;
        }

        .navbar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card img {
            height: 350px;
            object-fit: cover;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #343a40;
        }

        .card-text {
            font-size: 0.9rem;
            color: #555;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">School Bus Tracking System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="parent_track.php">Track Location</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="logout()">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content Section -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <img src="image/livelocation.png" class="card-img-top" alt="Bus Location">
                    <div class="card-body">
                        <h5 class="card-title">Track Location</h5>
                        <p class="card-text">School bus tracking systems use GPS technology to monitor the location of school buses in real-time. This allows parents to track the bus's progress effectively.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <img src="image/noworry.png" class="card-img-top" alt="No Worry">
                    <div class="card-body">
                        <h5 class="card-title">No Need to Worry</h5>
                        <p class="card-text">This system enhances safety and provides peace of mind for parents by allowing them to monitor their child's journey to and from school in real-time.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <img src="image/loop.png" class="card-img-top" alt="No Worry">
                    <div class="card-body">
                        <h5 class="card-title">Keep the parents in the loop</h5>
                        <p class="card-text">The kids security during the transportation is the primary concern of the parents. With the tracking solution, they know the location of the kids.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function logout() {
            alert('You have been logged out.');
            window.location.href = "login.html";
        }
    </script>
</body>
</html>
