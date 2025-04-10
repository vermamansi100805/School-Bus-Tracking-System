<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beautiful Navbar Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(120deg, #fdfbfb, #ebedee);
            min-height: 100vh;
        }
        .navbar {
            background-color: #007bff;
            padding: 0.5rem 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .nav-items {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-item {
            position: relative;
            margin: 0 15px;
        }

        .nav-item a {
            display: block;
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: bold;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease-in-out;
        }

        .nav-item a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }

        #content {
            background: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            margin: 15px;
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
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg">
        <ul class="nav-items">
        <li class="nav-item">
             <a href="start_tracking.php" onclick="startTracking()">Start Tracking</a>
        </li>
            <li class="nav-item">
                <a href="driver_track.php">Track Location</a>
            </li>
            <li class="nav-item">
                <a href="stop_tracking.php" onclick="stopTracking()">Stop Tracking</a>
            </li>
            <!-- Inside Navigation Bar -->
            <li class="nav-item">
                 <select id="busSelector" class="form-select">
                    <option value="">Loading buses...</option>
                 </select>
            </li>
            <li class="nav-item">
                 <button class="btn btn-danger mt-2" onclick="leaveBus()">Leave Bus</button>
            </li>
            <li class="nav-item">
                <a href="#" onclick="logout()">Logout</a>
            </li>
        </ul>
    </nav>

    <!-- Content Section -->
    <div id="content" class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="image/start_tracking.webp" alt="Start Tracking">
                    <div class="card-body">
                        <h3>Start Tracking</h3>
                        <p>This enables accurate navigation, route tracking, the system will continuously track and update the driver's position</p>
                 </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="image/livelocation1.jpeg" alt="Track Location">
                    <div class="card-body">
                        <h3>Track Location</h3>
                     <p>This allows for precise navigation, tracking of travel routes, and enables services like fleet management or delivery updates.</p></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="image/stop_tracking.webp" alt="Stop Tracking">
                    <div class="card-body">
                        <h3>Stop Tracking</h3>
                        <p>This action ensures that the driver's whereabouts are no longer being shared, giving them full control over their privacy.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function logout() {
            // Redirect to the login page
            window.location.href = "login.html"; // Replace with the appropriate URL
            alert('You have been logged out.');
        }
        function startTracking() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "start_tracking.php", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert(xhr.responseText); // Show popup alert
                    location.reload();
                }
            };
            xhr.send();
        }

        function stopTracking() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "stop_tracking.php", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert(xhr.responseText); // Show popup alert
                    location.reload();
                }
            };
            xhr.send();
        }
       // ✅ Function to populate the bus dropdown
    function loadBusNumbers() {
    fetch('get_bus_no.php')
        .then(response => response.json())
        .then(busList => {
            let dropdown = document.getElementById('busSelector');
            dropdown.innerHTML = '<option value="">Select Bus</option>';
            busList.forEach(busNo => {
                let option = document.createElement('option');
                option.value = busNo;
                option.textContent = `Bus No: ${busNo}`;
                dropdown.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));
    }

    // ✅ Function to send "Leave" email
    function leaveBus() {
    let busNo = document.getElementById('busSelector').value;
    if (!busNo) {
        alert("Please select a bus.");
        return;
    }

    if (confirm(`Are you sure you want to leave Bus No: ${busNo}?`)) {
        fetch('send_email_leave.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ bus_no: busNo })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
        })
        .catch(error => console.error('Error:', error));
    }
    }

    // ✅ Load bus numbers when the page loads
    document.addEventListener('DOMContentLoaded', loadBusNumbers);

    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>