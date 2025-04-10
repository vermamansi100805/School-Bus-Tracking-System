<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'project');

if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed']));
}

// Get bus numbers from the driver_login table
$sql = "SELECT bus_no FROM driver_login WHERE status = 'active'";
$result = $conn->query($sql);

$busNumbers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $busNumbers[] = $row['bus_no'];
    }
}

header('Content-Type: application/json');
echo json_encode($busNumbers);

$conn->close();
