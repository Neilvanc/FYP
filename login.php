<?php
session_start(); 

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$conn = mysqli_connect("localhost", "root", "", "phpmyadmin");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM userss WHERE email=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row["approval_status"] === "approved") { 
            if (password_verify($password, $row["password"])) {
                $_SESSION["userLoggedIn"] = true;
                $_SESSION["email"] = $email;

                if ($row["user_type"] === "admin") {
                    $_SESSION["user_type"] = "admin";
                } else {
                    $_SESSION["user_type"] = "user";
                }

                header("Location: FYP.php");
                exit(); 
            } else {
                echo "<script>alert('Invalid password!'); window.location.href = 'login.html';</script>";
            }
        } else {
            echo "Your account is pending approval. You cannot login yet.";
        }
    } else {
        echo "<script>alert('Invalid password!'); window.location.href = 'login.html';</script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
