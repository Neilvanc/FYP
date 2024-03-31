<?php
// Connect to your database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpmyadmin";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the database where approval_status is pending
$sql = "SELECT * FROM userss WHERE approval_status = 'pending'";
$result = $conn->query($sql);

if (!$result) {
    echo "Error: " . $sql . "<br>" . $conn->error;
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Approval</title>
    <style>
  body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .action-buttons button {
            padding: 8px 12px;
            margin-right: 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .approve-btn {
            background-color: #4CAF50;
            color: white;
        }

        .reject-btn {
            background-color: #f44336;
            color: white;
        }

        .approve-btn:hover, .reject-btn:hover {
            opacity: 0.8;
        }

        .no-users-msg {
            font-style: italic;
            color: #999;
        }    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['user_type']; ?></td>
                        <td>
                            <form action="update_status.php" method="POST">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="approve">Approve</button>
                                <button type="submit" name="reject">Reject</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='4'>No users pending approval.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
}

$conn->close();
?>
