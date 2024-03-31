<?php
session_start();

require_once('result.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect("localhost", "root", "", "phpmyadmin");

if (!$conn) {
    die('Error in database connection: ' . mysqli_connect_error());
}
$userType = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : 'user';

function getUserRole($conn, $email) {
    $query = "SELECT user_type FROM userss WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt === false) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, 's', $email);

    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return false;
    }

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row === null) {
        mysqli_stmt_close($stmt);
        return false;
    }
    return $row['user_type'];
}
if (isset($_POST['login'])) {
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $password = trim(mysqli_real_escape_string($conn, $_POST['password']));

    if (authenticateUser($conn, $email, $password)) {
        $userEmail = $email;
        $_SESSION['email'] = $userEmail;
        $_SESSION['user_type'] = getUserRole($conn, $email);


        header('Location: result1.php');
        exit();
    } else {
        echo 'Invalid email or password';
    }
}
$userRole = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : null;

if (isset($_GET['plant_name'])) {
    $plant_name = trim(mysqli_real_escape_string($conn, $_GET['plant_name']));

    $plant_name_lowercase = strtolower($plant_name);
    $isAdmin = isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';

    $query = "SELECT * FROM phpmyadmin.fypplant WHERE plantname = ? AND approval_status = 'approved'";

    $stmt = mysqli_prepare($conn, $query);

    if ($stmt === false) {
        die('Error in preparing statement: ' . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, 's', $plant_name_lowercase);

    if (!mysqli_stmt_execute($stmt)) {
        die('Error in executing the query: ' . mysqli_stmt_error($stmt));
    }

    $result = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_assoc($result);

    if ($result === false) {
        die('Error in getting result set: ' . mysqli_error($conn));
    }
    

    mysqli_stmt_close($stmt);
}

function authenticateUser($conn, $email, $password) {
    $hashedPassword = md5($password);

    $query = "SELECT * FROM userss WHERE email = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt === false) {
        return false;
        }

    mysqli_stmt_bind_param($stmt, 'ss', $email, $hashedPassword);

    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return false;
        }

    $result = mysqli_stmt_get_result($stmt);

    if ($result === false) {
        mysqli_stmt_close($stmt);
        return false;
    }

}


mysqli_close($conn);

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="icon.png">
    <title><?php echo isset($row) ? htmlspecialchars(  strtoupper($plant_name)) : 'Default Title'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
            #downloadPDF {
            display: none; 
        }
#printBtn {
    position: fixed;
    top: 0;
    right: 0; 
    margin: 10px;
    padding: 10px;
    background-color: #d3d3d3; 
    color: black;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}
        table {
            font-family: Arial, sans-serif;
            font-size: 16px;
            border-collapse: collapse;
            margin: auto;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 10px;
        }

        th {
            background-color: #f2f2f2;
        }

      

        td:first-child {
            width: 30%;
        }

        td:last-child {
            width: 60%;
        }

        .plant-image-td {
        display: flex;
        flex-direction: column;          
        align-items: center;             
    }

    .plant-image-td img {
        margin-bottom: 10px;             
        max-width: 100%;                 
        height: auto;                    
    }
    </style>
</head>
<body>

    <table>
        <tbody>

            <tr>    
            <td colspan="2">
    <center>
        <b><h1><?php echo isset($row['plantname']) ? htmlspecialchars(strtoupper($row['plantname'])) : 'Plant Unknown'; ?></h1></b>
    </center>
</td>
</tr>

<tr>
                <td><b>Plant Name:</b></td>
                <td><?php echo isset($row['plantname']) ? htmlspecialchars(strtoupper($row['plantname'])) : ''; ?></td>
            </tr>
<tr><tr>
    <?php if ($userRole !== null) : ?>
        <td><b>Informer:</b></td>
        <td><?php echo $row['Informer']; ?></td>
    <?php endif; ?>
</tr>
<tr>
    <?php if ($userRole !== null) : ?>
        <td><b>Collector:</b></td>
        <td><?php echo $row['Collector']; ?></td>
    <?php endif; ?>
</tr>
<tr>
    <?php if ($userRole !== null) : ?>
        <td><b>Date of Collection:</b></td>
        <td><?php echo $row['Date']; ?></td>
    <?php endif; ?>
</tr>
<tr>
    <?php if ($userRole !== null) : ?>
        <td><b>Sample Number:</b></td>
        <td><?php echo $row['Sampleno']; ?></td>
    <?php endif; ?>
</tr>
            <?php if ($userRole === 'admin') : ?>
                <tr>
        <td><b>Coordinate:</b></td>
        <td>
            <?php if (!empty($row['Coordinate'])) : ?>
                <?php

                $encodedCoordinates = urlencode($row['Coordinate']);

                $mapUrl = "https://www.google.com/maps/search/?api=1&query={$encodedCoordinates}";
                ?>
                <a href="<?php echo $mapUrl; ?>" target="_blank"><?php echo $row['Coordinate']; ?></a>
            <?php else : ?>
                <?php echo $row['Coordinate']; ?>
            <?php endif; ?>
        </td>
    </tr>

            <?php endif; ?>

            <tr>
                <td><b>Community:</b></td>
                <td><?php echo $row['Community']; ?></td>
            </tr>
            <tr>
                <td><b>Specific Locality:</b></td>
                <td><?php echo $row['Specificloc']; ?></td>
            </tr>
            <tr>
                <td><b>Climate:</b></td>
                <td><?php echo $row['Climate']; ?></td>
            </tr>
            <tr>
                <td><b>Soil:</b></td>
                <td><?php echo $row['Soil']; ?></td>
            </tr>
            <tr>
                <td><b>Other:</b></td>
                <td><?php echo $row['Other']; ?></td>
            </tr>
            <tr>
                <td><b>Lifeform/Vegetation Type:</b></td>
                <td><?php echo $row['Lifeform']; ?></td>
            </tr> 
             <tr>
                <td><b>Height:</b></td>
                <td><?php echo $row['Height']; ?></td>
            </tr> 
            <tr>
                <td><b>Diameter:</b></td>
                <td><?php echo $row['Diameter']; ?></td>
            </tr> 
            <tr>
                <td><b>Color:</b></td>
                <td><?php echo $row['Colour']; ?></td>
            </tr> <tr>
                <td><b>Of Flower:</b></td>
                <td><?php echo $row['flower']; ?></td>
            </tr> <tr>
                <td><b>Of Fruit:</b></td>
                <td><?php echo $row['fruit']; ?></td>
            </tr> <tr>
                <td><b>Other notes on appereance:</b></td>
                <td><?php echo $row['Othernote']; ?></td>
            </tr> <tr>
                <td><b>Flowring Season:</b></td>
                <td><?php echo $row['Floweringseason']; ?></td>
            </tr> <tr>
                <td><b>Fruiting Season:</b></td>
                <td><?php echo $row['Fruitingseason']; ?></td>
            </tr> <tr>
                <td><b>Local Name:</b></td>
                <td><?php echo $row['Localname']; ?></td>
            </tr> <tr>
                <td><b>Translation:</b></td>
                <td><?php echo $row['Translation']; ?></td>
            </tr>
            <tr>
                <td><b>Scientific Name:</b></td>
                <td><?php echo $row['Scientificname']; ?></td>
            </tr>  
             <tr>
                <td><b>[1] Use:</b></td>
                <td><?php echo $row['Used']; ?></td>
            </tr> <tr>
                <td><b>[1] Preparation:</b></td>
                <td><?php echo $row['Preparation']; ?></td>
            </tr> <tr>
                <td><b>Other notes on use and preparation:</b></td>
                <td><?php echo $row['Otherpreparation']; ?></td>
            </tr>
            <tr>
    <td><b>Photos:</b></td>
    <td class="plant-image-td" data-plant="<?php echo strtolower($row['plantname']); ?>" style="width: 96.9%;">
        <?php
        $pictures = explode(',', $row['picture']); 
        
        if (!empty($pictures)) {
            foreach ($pictures as $picture) {
                echo '<img src="' . $picture . '" alt="" style="max-width: 300px; margin-bottom: 10px;">';
            }
        }
        ?>
    </td>
</tr>
<tr>
    <td><b>Edit:</b></td>
    <td>
        <a href="edit_plant.php?plant_name=<?php echo urlencode($row['plantname']); ?>">Edit</a>
    </td>
</tr>
        </tbody>
    </table>
    <button id="downloadPDF"><i class="fa fa-download"></i> Save</button>
    <button id="printBtn"><i class="fa fa-print" ></i>Print</button>

<script>
    document.getElementById('downloadPDF').addEventListener('click', function() {
        var doc = new jsPDF();
        
        doc.autoTable({ html: 'table' });
        
        doc.save('<?php echo isset($row) ? htmlspecialchars(strtoupper($plant_name)) : 'table'; ?>.pdf');
    });

    document.getElementById('printBtn').addEventListener('click', function() {
        window.print();
    });
</script>

</body>

<?php if (isset($row)) : ?>
<?php endif; ?>

</html>