<?php
session_start();

require_once('result.php');

$conn = mysqli_connect("localhost", "root", "", "phpmyadmin");

if (!$conn) {
    die('Error in database connection: ' . mysqli_connect_error());
}

if (isset($_SESSION['user_type']) && isset($_GET['plant_name'])) {
    $plant_name = trim(mysqli_real_escape_string($conn, $_GET['plant_name']));

    $query = "SELECT * FROM phpmyadmin.fypplant WHERE LOWER(plantname) = LOWER(?) AND approval_status = 'approved'";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt === false) {
        die('Error in preparing statement: ' . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, 's', $plant_name);

    if (!mysqli_stmt_execute($stmt)) {
        die('Error in executing the query: ' . mysqli_stmt_error($stmt));
    }

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row === null) {
        die('Plant not found or awaiting approval.');
    }

    mysqli_stmt_close($stmt);
} else {
    die('You need to  login to edit the plant data.');
}

if (isset($_POST['submit'])) {
    $plantName = ucfirst(strtolower($_POST['plantname']));
    $informer = $_POST['informer'];
    $collector = $_POST['collector'];
    $Date = $_POST['Date'];
    $Sampleno = $_POST['Sampleno'];
    $Coordinate = $_POST['Coordinate'];
    $Community = $_POST["Community"];
    $Specificloc = $_POST["Specificloc"];
    $Climate = $_POST["Climate"];
    $Soil = $_POST["Soil"];
    $Other = $_POST["Other"];
    $Lifeform = $_POST["Lifeform"];
    $Height = $_POST["Height"];
    $Diameter = $_POST["Diameter"];
    $Colour = $_POST["Color"];
    $flower = $_POST["flower"];
    $fruit = $_POST["fruit"];
    $Othernote = $_POST["Othernote"];
    $Floweringseason = $_POST["Floweringseason"];
    $Fruitingseason = $_POST["Fruitingseason"];
    $Localname = $_POST["Localname"];
    $Translation = $_POST["Translation"];
    $Scientificname = $_POST["Scientificname"];
    $Used = $_POST["Used"];
    $Preparation = $_POST["Preparation"];
    $Otherpreparation = $_POST["Otherpreparation"];

    $update_query = "UPDATE phpmyadmin.fypplant SET Informer = ?, Collector = ?, Date = ?, Sampleno = ?, Coordinate = ?, Community = ?, Specificloc = ?, Climate = ?, Soil = ?, Other = ?, Lifeform = ?, Height = ?, Diameter = ?, Colour = ?, flower = ?, fruit = ?, Othernote = ?, Floweringseason = ?, Fruitingseason = ?, Localname = ?, Translation = ?, Scientificname = ?, Used = ?, Preparation = ?, Otherpreparation = ?";

    if ($_SESSION['user_type'] !== 'admin') {
        $update_query .= ", approval_status = 'pending'";
    }

    if (!empty($_FILES["newImage"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["newImage"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($_FILES["newImage"]["error"] !== UPLOAD_ERR_OK) {
            die("Error uploading file: " . $_FILES["newImage"]["error"]);
        }

        if (file_exists($target_file)) {
            die("Sorry, file already exists.");
        }

        if ($_FILES["newImage"]["size"] > 500000) {
            die("Sorry, your file is too large.");
        }

        $allowedFormats = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowedFormats)) {
            die("Sorry, only JPG, JPEG, PNG, and GIF files are allowed.");
        }

        if (move_uploaded_file($_FILES["newImage"]["tmp_name"], $target_file)) {
            $update_query .= ", picture = ?";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    $update_query .= " WHERE LOWER(plantname) = LOWER(?)";

    $update_stmt = mysqli_prepare($conn, $update_query);

    if ($update_stmt === false) {
        die('Error in preparing update statement: ' . mysqli_error($conn));
    }

    if (!empty($_FILES["newImage"]["name"])) {
        mysqli_stmt_bind_param($update_stmt, 'sssssssssssssssssssssssssss', $informer, $collector, $Date, $Sampleno, $Coordinate, $Community, $Specificloc, $Climate, $Soil, $Other, $Lifeform, $Height, $Diameter, $Colour, $flower, $fruit, $Othernote, $Floweringseason, $Fruitingseason, $Localname, $Translation, $Scientificname, $Used, $Preparation, $Otherpreparation, $target_file, $plant_name);
    } else {
        mysqli_stmt_bind_param($update_stmt, 'ssssssssssssssssssssssssss', $informer, $collector, $Date, $Sampleno, $Coordinate, $Community, $Specificloc, $Climate, $Soil, $Other, $Lifeform, $Height, $Diameter, $Colour, $flower, $fruit, $Othernote, $Floweringseason, $Fruitingseason, $Localname, $Translation, $Scientificname, $Used, $Preparation, $Otherpreparation, $plant_name);
    }

    if (!mysqli_stmt_execute($update_stmt)) {
        die('Error in executing the update query: ' . mysqli_stmt_error($update_stmt));
    }

    echo '';

    mysqli_stmt_close($update_stmt);
    echo "Plant data updated. ";

    echo '<div style="text-align: center; margin-top: 20px;"><a href="allplant1.php"><button>Back to All Plants</button></a></div>';

    if ($_SESSION['user_type'] !== 'admin') {
        echo "Please wait for admin approval.";
    }

    exit;
}

mysqli_close($conn);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="icon.png">
    <title>Edit Plant Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"] {
            width: calc(100% - 12px);
            padding: 6px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Edit Plant Data</h1>
    <form method="post" enctype="multipart/form-data">
        <label for="plantname">Plant Name:</label>
        <input type="text" id="plantname" name="plantname" value="<?php echo htmlspecialchars($row['plantname']); ?>"><br><br>
        
        <label for="informer">Informer:</label>
        <input type="text" id="informer" name="informer" value="<?php echo htmlspecialchars($row['Informer']); ?>"><br><br>
        
        <label for="collector">Collector:</label>
        <input type="text" id="collector" name="collector" value="<?php echo htmlspecialchars($row['Collector']); ?>"><br><br>

        <label for="Date">Date of Collection:</label>
        <input type="text" id="Date" name="Date" value="<?php echo htmlspecialchars($row['Date']); ?>"><br><br>
        
        <label for="Sampleno">Sample Number:</label>
        <input type="text" id="Sampleno" name="Sampleno" value="<?php echo htmlspecialchars($row['Sampleno']); ?>"><br><br>
        
        <label for="Coordinate">Coordinate:</label>
        <input type="text" id="Coordinate" name="Coordinate" value="<?php echo htmlspecialchars($row['Coordinate']); ?>"><br><br>

        <label for="informer">Informer:</label>
        <input type="text" id="informer" name="informer" value="<?php echo htmlspecialchars($row['Informer']); ?>"><br><br>
        
        <label for="Community">Community:</label>
        <input type="text" id="Community" name="Community" value="<?php echo htmlspecialchars($row['Community']); ?>"><br><br>

        <label for="Specificloc">Specific Locality:</label>
        <input type="text" id="Specificloc" name="Specificloc" value="<?php echo htmlspecialchars($row['Specificloc']); ?>"><br><br>
        
        <label for="Climate">Climate:</label>
        <input type="text" id="Climate" name="Climate" value="<?php echo htmlspecialchars($row['Climate']); ?>"><br><br>
 
        <label for="Soil">Soil:</label>
        <input type="text" id="Soil" name="Soil" value="<?php echo htmlspecialchars($row['Soil']); ?>"><br><br>

        <label for="Other">Other:</label>
        <input type="text" id="Other" name="Other" value="<?php echo htmlspecialchars($row['Other']); ?>"><br><br>

        <label for="Lifeform">Lifeform/Vegetation Type:</label>
        <input type="text" id="Lifeform" name="Lifeform" value="<?php echo htmlspecialchars($row['Lifeform']); ?>"><br><br>
        
        <label for="collector">Collector:</label>
        <input type="text" id="collector" name="collector" value="<?php echo htmlspecialchars($row['Collector']); ?>"><br><br>

        <label for="Height">Height:</label>
        <input type="text" id="Height" name="Height" value="<?php echo htmlspecialchars($row['Height']); ?>"><br><br>
        
        <label for="Diameter">Diameter:</label>
        <input type="text" id="Diameter" name="Diameter" value="<?php echo htmlspecialchars($row['Diameter']); ?>"><br><br>

        <label for="Color">Color:</label>
        <input type="text" id="Color" name="Color" value="<?php echo htmlspecialchars($row['Colour']); ?>"><br><br>
        
        <label for="flower">Of Flower:</label>
        <input type="text" id="flower" name="flower" value="<?php echo htmlspecialchars($row['flower']); ?>"><br><br>
        
        <label for="fruit">Of Fruit:</label>
        <input type="text" id="fruit" name="fruit" value="<?php echo htmlspecialchars($row['fruit']); ?>"><br><br>

        <label for="Othernote">Other notes on appereance:</label>
        <input type="text" id="Othernote" name="Othernote" value="<?php echo htmlspecialchars($row['Othernote']); ?>"><br><br>
        
        <label for="Floweringseason">Flowring Season:</label>
        <input type="text" id="Floweringseason" name="Floweringseason" value="<?php echo htmlspecialchars($row['Floweringseason']); ?>"><br><br>

        <label for="Fruitingseason">Fruiting Season:</label>
        <input type="text" id="Fruitingseason" name="Fruitingseason" value="<?php echo htmlspecialchars($row['Fruitingseason']); ?>"><br><br>

        <label for="Localname">Local Name:</label>
        <input type="text" id="Localname" name="Localname" value="<?php echo htmlspecialchars($row['Localname']); ?>"><br><br>
        
        <label for="Translation">Translation:</label>
        <input type="text" id="Translation" name="Translation" value="<?php echo htmlspecialchars($row['Translation']); ?>"><br><br>
        
        <label for="Scientificname">Scientific Name:</label>
        <input type="text" id="Scientificname" name="Scientificname" value="<?php echo htmlspecialchars($row['Scientificname']); ?>"><br><br>
       
        <label for="Used">[1] Use:</label>
        <input type="text" id="Used" name="Used" value="<?php echo htmlspecialchars($row['Used']); ?>"><br><br>
        
        <label for="Preparation">[1] Preparation:</label>
        <input type="text" id="Preparation" name="Preparation" value="<?php echo htmlspecialchars($row['Preparation']); ?>"><br><br>
        
        <label for="Otherpreparation">Other notes on use and preparation:</label>
        <input type="text" id="Otherpreparation" name="Otherpreparation" value="<?php echo htmlspecialchars($row['Otherpreparation']); ?>"><br><br>

        <td>Photos:</td>
        <br>
<td class="plant-image-td" data-plant="<?php echo strtolower($row['plantname']); ?>" style="width: 96.9%;">
    <?php
    $pictures = explode(',', $row['picture']); 
    
    if (!empty($pictures)) {
        $firstPicture = reset($pictures); 
        echo '<img src="' . $firstPicture . '" alt="" style="max-width: 300px; margin-bottom: 10px;">';
    }
    ?>
    <br>
        <label for="newImage">Upload New Image:</label>
        <input type="file" id="newImage" name="newImage"><br>    
</td>
<br>
<br>
<p style="color: red;">If there is no Information write "-"</p>

        <input type="submit" name="submit" value="Submit">
    </form>
    <?php if (isset($_POST['submit'])): ?>
        <p style="text-align: center; margin-top: 20px;">Plant data updated. Please wait for admin approval.</p>
    <?php endif; ?>

</body>
</html>