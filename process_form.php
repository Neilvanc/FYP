<?php
session_start();

if (!isset($_SESSION["userLoggedIn"])) {
    header("Location: login.php");
    exit();
}

require_once('result.php');

$plantName = $Informer = $Collector = $Date = $Sampleno = $Coordinate = $Community = $Specificloc = $Climate = $Soil = $Other = $Lifeform = $Height = $Diameter = $flower = $fruit = $Othernote = $Floweringseason = $Fruitingseason = $Localname = $Translation = $Scientificname = $Used = $Preparation = $Otherpreparation = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uploaded_files = [];
    if (!empty($_FILES["Photos"]["name"][0])) {
        $targetDirectory = "uploads/"; 
        
        foreach ($_FILES["Photos"]["tmp_name"] as $key => $tmp_name) {
            $file_name = $_FILES["Photos"]["name"][$key];
            $file_tmp = $_FILES["Photos"]["tmp_name"][$key];
            $targetFile = $targetDirectory . basename($file_name); 
            
            if (file_exists($targetFile)) {
                echo "Sorry, file already exists.";
            } else {
                if (move_uploaded_file($file_tmp, $targetFile)) {
                    $uploaded_files[] = $targetFile;
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    }
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
} 

if ($_SESSION['user_type'] !== 'admin') {
    $update_query .= ", approval_status = 'pending'";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $plantName = strtolower(trim($_POST["plantName"]));

    $Collector = trim($_POST["Collector"]);

    $Informer = trim($_POST["Informer"]);
 
    $Date = trim($_POST["Date"]);

    $Sampleno = trim($_POST["Sampleno"]);

    $Coordinate = trim($_POST["Coordinate"]);

    $Community = trim($_POST["Community"]);

    $Specificloc = trim($_POST["Specificloc"]);

    $Climate = trim($_POST["Climate"]);

    $Soil = trim($_POST["Soil"]);

    $Lifeform = trim($_POST["Lifeform"]);

    $Other = trim($_POST["Other"]);


    $Height = trim($_POST["Height"]);

    $Diameter = trim($_POST["Diameter"]);

    $Colour = trim($_POST["Colour"]);

    $flower = trim($_POST["flower"]);

    $fruit = trim($_POST["fruit"]);

    $Othernote = trim($_POST["Othernote"]);

    $Floweringseason = trim($_POST["Floweringseason"]);

    $Fruitingseason = trim($_POST["Fruitingseason"]);
    $Localname = trim($_POST["Localname"]);
    $Translation = trim($_POST["Translation"]);
    $Scientificname = trim($_POST["Scientificname"]);
    $Used = trim($_POST["Used"]);
    $Preparation = trim($_POST["Preparation"]);
    $Otherpreparation = trim($_POST["Otherpreparation"]);
    

    $approvalStatus = ($_SESSION['user_type'] === 'admin') ? 'approved' : 'pending';

    $sql = "INSERT INTO fypplant (plantName, Informer, Collector, Date, Sampleno, Coordinate, Community, Specificloc, Climate, Soil, Lifeform, Other, Height, Diameter, Colour, flower, fruit, Othernote, Floweringseason, Fruitingseason, Localname, Translation, Scientificname, Used, Preparation, Otherpreparation, picture, approval_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssssssssssssssssssssssssss", $plantName, $Informer, $Collector, $Date, $Sampleno, $Coordinate, $Community, $Specificloc, $Climate, $Soil, $Lifeform, $Other, $Height, $Diameter, $Colour, $flower, $fruit, $Othernote, $Floweringseason, $Fruitingseason, $Localname, $Translation, $Scientificname, $Used, $Preparation, $Otherpreparation, $targetFile, $approvalStatus);
    
        if (!empty($uploaded_files)) {
            $imageData = file_get_contents($uploaded_files[0]); 
            mysqli_stmt_send_long_data($stmt, 27, $imageData);
        } else {
            $targetFile = "";
        }
    
        if (mysqli_stmt_execute($stmt)) {
            header("Location: allplant1.php");
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }
    
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn); 
    }

    mysqli_close($conn);
}

header("Location: allplant1.php");
exit();

?>
