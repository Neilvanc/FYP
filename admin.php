<!DOCTYPE html>
<html>
<head>
    <title>Submission Approval</title>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f2f2f2;
        }

        .submission-container {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #f9f9f9;
            max-width: 600px;
            width: 100%;
        }

        .submission-details {
            margin-bottom: 10px;
        }

        .form-buttons input[type="submit"] {
            margin-right: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .form-buttons input[type="submit"][name="reject"] {
            background-color: #f44336;
        }

        .no-submissions {
            font-style: italic;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
<h1>Plant Request</h1>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpmyadmin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM phpmyadmin.fypplant WHERE approval_status IS NULL OR approval_status = 'pending'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="submission-container">';
        echo '<div class="submission-details">';
        echo "<p><strong>Plant Name:</strong> " . $row["plantname"]. "</p>";
        echo "<p><strong>Informer:</strong> " . $row["Informer"]. "</p>";
        echo "<p><strong>Collector:</strong> " . $row["Collector"]. "</p>";
        echo "<p><strong>Date:</strong> " . $row["Date"]. "</p>";
        echo "<p><strong>Sample number:</strong> " . $row["Sampleno"]. "</p>";
        echo "<p><strong>Coordinate:</strong> " . $row["Coordinate"]. "</p>";
        echo "<p><strong>Community:</strong> " . $row["Community"]. "</p>";
        echo "<p><strong>Specific locality:</strong> " . $row["Specificloc"]. "</p>";
        echo "<p><strong>Climate:</strong> " . $row["Climate"]. "</p>";
        echo "<p><strong>Soil:</strong> " . $row["Soil"]. "</p>";
        echo "<p><strong>Other:</strong> " . $row["Other"]. "</p>";
        echo "<p><strong>Lifeform:</strong> " . $row["Lifeform"]. "</p>";
        echo "<p><strong>Height:</strong> " . $row["Height"]. "</p>";
        echo "<p><strong>Diameter:</strong> " . $row["Diameter"]. "</p>";
        echo "<p><strong>Color:</strong> " . $row["Colour"]. "</p>";
        echo "<p><strong>flower:</strong> " . $row["flower"]. "</p>";
        echo "<p><strong>fruit:</strong> " . $row["fruit"]. "</p>";
        echo "<p><strong>Other note:</strong> " . $row["Othernote"]. "</p>";
        echo "<p><strong>Flowering season:</strong> " . $row["Floweringseason"]. "</p>";
        echo "<p><strong>Fruiting season:</strong> " . $row["Fruitingseason"]. "</p>";
        echo "<p><strong>Local name:</strong> " . $row["Localname"]. "</p>";
        echo "<p><strong>Translation:</strong> " . $row["Translation"]. "</p>";
        echo "<p><strong>Scientific name:</strong> " . $row["Scientificname"]. "</p>";
        echo "<p><strong>Use:</strong> " . $row["Used"]. "</p>";
        echo "<p><strong>Preparation:</strong> " . $row["Preparation"]. "</p>";
        echo "<p><strong>Other preparation:</strong> " . $row["Otherpreparation"]. "</p>";
        if ($row["picture"]) {
            echo '<img class="plant-image" src="' . $row["picture"] . '" alt="Plant Image">';
        }
   
        echo '</div>'; 

        echo '<div class="form-buttons">';
        echo '<form action="approval_submission.php" method="post">';
        echo '<input type="hidden" name="plantname" value="' . $row["plantname"] . '">'; 
        echo '<input type="submit" name="approve" value="Approve">';
        echo '<input type="submit" name="reject" value="Reject">';
        echo '</form>';
        echo '</div>'; 

        echo '</div>'; 
    }
} else {
    echo '<p class="no-submissions">No submissions pending approval.</p>';
}

$conn->close();
?>

</body>
</html>
