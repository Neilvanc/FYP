<?php
session_start(); 

require_once('result.php');

if (isset($_POST['delete'])) {
    $plantName = $_POST['delete'];
    
    $query = "DELETE FROM phpmyadmin.fypplant WHERE LOWER(plantname) = LOWER('$plantName')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Plant '$plantName' deleted successfully.";
    } else {
        echo "Error deleting plant: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
