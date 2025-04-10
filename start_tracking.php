<?php
session_start();
include 'config.php';

if (!isset($_SESSION['driver_id'])) {
    echo "<script>alert('User not logged in.'); window.location.href='driver_dashboard.php';</script>";
    exit();
}

$driver_id = $_SESSION['driver_id']; // Correct session variable

$sql = "UPDATE driver_login SET status = 'active' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $driver_id);

if ($stmt->execute()) {
    echo "GPS is ON";
} else {
    echo "Failed to update status";
}

$stmt->close();
$conn->close();
?>
