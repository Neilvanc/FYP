<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="icon.png">
    <title>All Plants</title>
    <style>
.a {
    position: fixed;
    top: 0;
    right: 0; 
    margin: 10px;
    padding: 10px;
    background-color: #333; 
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}
  </style>
</head>
<body>
    <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpmyadmin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $plantname = $_POST["plantname"];
    if (isset($_POST["approve"])) {
        $sql = "UPDATE phpmyadmin.fypplant SET approval_status = 'approved' WHERE plantname = '$plantname'";
        if ($conn->query($sql) === TRUE) {
            echo "Submission approved successfully.";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } elseif (isset($_POST["reject"])) {
        $sql = "UPDATE phpmyadmin.fypplant SET approval_status = 'rejected' WHERE plantname = '$plantname'";
        if ($conn->query($sql) === TRUE) {
            echo "Submission rejected successfully.";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}

$conn->close();
?>
    <a href="allplant1.php" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;">Go to All Plants</a>
</body>
</html>
