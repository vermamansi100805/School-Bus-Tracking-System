<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM driver_login WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // Redirect back to the viewing page after deletion
        header("Location: driver_viewing.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>
