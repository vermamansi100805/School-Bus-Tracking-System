<?php
require_once 'config.php';

// Fetch data from parent_login table
$sql = "SELECT roll_no, student_name, email, contact_number, home_address, bus_stop, bus_no, class FROM parent_login";
$result = $conn->query($sql);

// Handle delete request
if (isset($_GET['delete_roll_no'])) {
    $delete_roll_no = $_GET['delete_roll_no'];
    $delete_sql = "DELETE FROM parent_login WHERE roll_no = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("s", $delete_roll_no);

    if ($stmt->execute()) {
        echo "<script>alert('Student deleted successfully!'); window.location.href='student_viewing.php';</script>";
    } else {
        echo "<script>alert('Error deleting student!');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
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
        <h1 class="text-center">Student List</h1>
        <table class="table table-bordered mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>Roll No</th>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Home Address</th>
                    <th>Bus Stop</th>
                    <th>Bus No</th>
                    <th>Student Class</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['roll_no']}</td>
                                <td>{$row['student_name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['contact_number']}</td>
                                <td>{$row['home_address']}</td>
                                <td>{$row['bus_stop']}</td>
                                <td>{$row['bus_no']}</td>
                                <td>{$row['class']}</td>
                                <td>
                                    <a href='update_student.php?roll_no={$row['roll_no']}' class='btn btn-warning btn-sm'>Update</a>
                                    <a href='?delete_roll_no={$row['roll_no']}' class='btn btn-danger btn-sm'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>No Students found</td></tr>";
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
