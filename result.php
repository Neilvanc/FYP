
<?php
$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "phpmyadmin";



$conn = mysqli_connect($serverName, $userName, $password, $dbName, 3306);
if (!$conn){
    die("Connection Error");
}
?>
<?php

$isLoggedIn = isset($_SESSION['user_id']);

require_once('result.php');
