<?php
$conn = mysqli_connect("localhost", "root", "", "phpmyadmin");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $userType = $_POST["role"]; 
    $approvalStatus = "pending";

    $sql = "INSERT INTO userss (username, email, password, user_type, approval_status) 
            VALUES ('$username', '$email', '$password', '$userType', '$approvalStatus')";

    try {
        if (mysqli_query($conn, $sql)) {
            echo "Registration successful!";
            
            header("Location: login.html");
            exit(); 
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            echo "Error: The username '$username' is already registered. Please choose a different username.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}

mysqli_close($conn);
?>
