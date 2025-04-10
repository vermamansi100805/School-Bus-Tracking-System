<?php
// Database connection
$host = "localhost";       // or use 127.0.0.1
$user = "root";
$password = "";
$dbname = "project";       // your actual database name

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        "error" => true,
        "message" => "Database connection failed: " . $conn->connect_error
    ]));
}

if (isset($_GET['bus_no'])) {
    $bus_no = $_GET['bus_no'];

    $stmt = $conn->prepare("SELECT latitude, longitude FROM bus_locations WHERE bus_no = ?");
    $stmt->bind_param("s", $bus_no);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            "latitude" => $row['latitude'],
            "longitude" => $row['longitude']
        ]);
    } else {
        echo json_encode([
            "error" => true,
            "message" => "No location found for bus $bus_no"
        ]);
    }
} else {
    echo json_encode([
        "error" => true,
        "message" => "Missing bus_no parameter"
    ]);
}

$conn->close();
?>
