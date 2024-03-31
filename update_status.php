<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to your database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "phpmyadmin";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check which button is clicked
    if (isset($_POST['approve'])) {
        $status = 'approved';
    } elseif (isset($_POST['reject'])) {
        $status = 'rejected';
    }

    // Get the user ID from the form
    $user_id = $_POST['user_id'];

    // Update the approval status in the database
    $sql = "UPDATE userss SET approval_status = '$status' WHERE id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo "User status updated successfully";
    } else {
        echo "Error updating user status: " . $conn->error;
    }

    $conn->close();
} else {
    // Redirect to the previous page if accessed directly without form submission
    header("Location: index.php");
    exit();
}
?>
