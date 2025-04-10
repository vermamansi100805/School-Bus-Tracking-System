<!-- connection -->
<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'project';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Google Maps API Key (Store securely)
$googleMapsApiKey = "YOUR_GOOGLE_MAPS_API_KEY";
?>
