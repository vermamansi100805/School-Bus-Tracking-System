<?php
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['bus_no']) || !isset($data['latitude']) || !isset($data['longitude'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data received']);
    exit;
}

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // ✅ Update existing record or insert new record
    $stmt = $conn->prepare("INSERT INTO bus_locations (bus_no, latitude, longitude) VALUES (?, ?, ?) 
                            ON DUPLICATE KEY UPDATE latitude = VALUES(latitude), longitude = VALUES(longitude), timestamp = CURRENT_TIMESTAMP");
    $stmt->bind_param("idd", $data['bus_no'], $data['latitude'], $data['longitude']);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Location updated']);
    } else {
        throw new Exception("Error updating location: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
