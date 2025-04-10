<?php
session_start();
include 'config.php'; // Database connection

if (!isset($_SESSION['driver_id'])) {
    echo "User not logged in.";
    exit();
}

$driver_id = $_SESSION['driver_id'];

// Update status to 'inactive'
$sql = "UPDATE driver_login SET status = 'inactive' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $driver_id);

if ($stmt->execute()) {
    echo "GPS is OFF"; // Message will be displayed in an alert box
} else {
    echo "Failed to stop tracking.";
}

$stmt->close();
$conn->close();
?>
