<?php
require_once 'config.php';

// Check if roll_no is set
if (isset($_GET['roll_no'])) {
    $roll_no = $_GET['roll_no'];
    
    // Fetch student details
    $sql = "SELECT * FROM parent_login WHERE roll_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $roll_no);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $roll_no = $_POST['roll_no'];
    $student_name = $_POST['student_name'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];
    $home_address = $_POST['home_address'];
    $bus_stop = $_POST['bus_stop'];
    $bus_no = $_POST['bus_no'];
    $class = $_POST['class'];

    $update_sql = "UPDATE parent_login SET student_name=?, email=?, contact_number=?, home_address=?, bus_stop=?, bus_no=?, class=? WHERE roll_no=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssssis", $student_name, $email, $contact_number, $home_address, $bus_stop, $bus_no, $class, $roll_no);
    
    if ($stmt->execute()) {
        echo "<script>alert('Student updated successfully!'); window.location.href='student_viewing.php';</script>";
    } else {
        echo "<script>alert('Error updating student!');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Update Student Details</h2>
        <form method="POST">
            <input type="hidden" name="roll_no" value="<?php echo $student['roll_no']; ?>">
            <div class="form-group">
                <label>Student Name</label>
                <input type="text" name="student_name" class="form-control" value="<?php echo $student['student_name']; ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $student['email']; ?>" required>
            </div>
            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" name="contact_number" class="form-control" value="<?php echo $student['contact_number']; ?>" required>
            </div>
            <div class="form-group">
                <label>Home Address</label>
                <textarea name="home_address" class="form-control" required><?php echo $student['home_address']; ?></textarea>
            </div>
            <div class="form-group">
                <label>Bus Stop</label>
                <input type="text" name="bus_stop" class="form-control" value="<?php echo $student['bus_stop']; ?>" required>
            </div>
            <div class="form-group">
                <label>Bus No</label>
                <input type="text" name="bus_no" class="form-control" value="<?php echo $student['bus_no']; ?>" required>
            </div>
            <div class="form-group">
                <label>Class</label>
                <input type="number" name="class" class="form-control" value="<?php echo $student['class']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="student_viewing.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
