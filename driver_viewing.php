<?php
require_once 'config.php';

// Fetch data from driver_login table
$sql = "SELECT id, bus_no, driver_name, email, contact_number, home_address FROM driver_login";
$result = $conn->query($sql);

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM driver_login WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<script>alert('Driver deleted successfully!'); window.location.href='driver_viewing.php';</script>";
    } else {
        echo "<script>alert('Error deleting driver!');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .footer {
            background-color: #f8f9fa;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
            border-top: 1px solid #ddd;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        } 
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Driver List</h1>
        <table class="table table-bordered mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Bus No</th>
                    <th>Driver Name</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Home Address</th>
                    <th>Action</th> <!-- New column for Delete button -->
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['bus_no']}</td>
                                <td>{$row['driver_name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['contact_number']}</td>
                                <td>{$row['home_address']}</td>
                                <td><a href='?delete_id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this driver?\");'>Delete</a></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No drivers found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="footer">
        <p>Go Back <a href="admin_dashboard.php">To Dashboard</a></p>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
