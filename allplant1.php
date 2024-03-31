<?php
session_start(); 

require_once('result.php');

$query = "SELECT DISTINCT plantname, picture, type, Date 
          FROM phpmyadmin.fypplant 
          WHERE approval_status = 'approved'";

$result = mysqli_query($conn, $query);

if (!$result) {
    die('Error executing query: ' . mysqli_error($conn));
}
$plants = array();
$types = array();


while ($row = mysqli_fetch_assoc($result)) {
    $plants[] = $row;
    $types[] = $row['type'];
}

$uniqueTypes = array_unique($types);


mysqli_free_result($result);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="icon.png">
    <title>Plant Collection</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .plant-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .plant-card {
            width: 200px;
            margin: 20px;
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease; 
        }
        .plant-card:hover {
            transform: scale(1.1); 
        }

        .hidden {
            display: none;
        }

        .plant-image {
            width: 100%;
            max-width: 200px;
            height: auto;
            border-radius: 5px;
        }

        .plant-name {
            margin-top: 10px;
            font-size: 18px;
            color: #333;
        }

        .filters {
            text-align: left; 
            margin-bottom: 20px;
        }

        .filter-dropdown {
    margin-left: 10px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
    cursor: pointer;

}
#login {
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
#request {
            position: absolute; 
            top: 10px; 
            left: 10px; 
            background-color: #333; 
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            padding: 10px;
        }
    </style>
</head>
<body>
    <h1>Plant Collection</h1>
    <?php if (isset($_SESSION["userLoggedIn"]) && $_SESSION["userLoggedIn"] === true && isset($_SESSION["user_type"]) && $_SESSION["user_type"] === "admin") : ?>
    <button id="request" onclick="location.href='admin.php'">Request</button>
<?php endif; ?>
    <?php if (isset($_SESSION["userLoggedIn"]) && $_SESSION["userLoggedIn"] === true) : ?>
    <button id="login" onclick="location.href='addplant.html'">Add Plant</button>
<?php endif; ?>
<div class="filters">
        <label for="filterDropdown" class="filter-dropdown">Filter by:</label>
        <select id="filterDropdown">
            <option value="all">All Plants</option>
            <?php foreach ($uniqueTypes as $type) : ?>
                <option value="<?php echo $type; ?>"><?php echo ucfirst($type); ?></option>
            <?php endforeach; ?>
        </select>
</div>

    </div>
    <form method="post" action="delete_plant.php">
    <div class="plant-container">
    <?php foreach ($plants as $plant) : ?>
        <?php
            $lowercasePlantName = strtolower($plant['plantname']);
            $plantImage = $plant['picture']; 
            $plantDate = $plant['Date']; 
       ?>

        <div class="plant-card" data-type="<?php echo $plant['type']; ?>" onclick="searchAndRedirect('<?php echo $lowercasePlantName; ?>')">
            <img class="plant-image" src="<?php echo $plantImage; ?>" alt="Plant Image">
            <p class="plant-name"><?php echo strtoupper($plant['plantname']); ?></p>
            <p class="plant-date"><?php echo $plantDate; ?></p> 
            <?php if (isset($_SESSION["userLoggedIn"]) && $_SESSION["userLoggedIn"] === true && isset($_SESSION["user_type"]) && $_SESSION["user_type"] === "admin") : ?>
            <form method="post" action="delete_plant.php">
                <button type="submit" name="delete" value="<?php echo $lowercasePlantName; ?>">Delete</button>
            </form>
        <?php endif; ?>

</div>

<?php endforeach; ?>

   
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterDropdown = document.getElementById('filterDropdown');
    const plantCards = document.querySelectorAll('.plant-card');

    filterDropdown.addEventListener('change', function () {
        const selectedFilter = filterDropdown.value;
        console.log('Selected filter:', selectedFilter); 

        plantCards.forEach(function (card) {
            const plantType = card.dataset.type;
            console.log('Plant type:', plantType); 

            if (selectedFilter === 'all' || selectedFilter === plantType) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    });

    plantCards.forEach(function (card) {
        card.addEventListener('click', function () {
            const plantName = card.querySelector('.plant-name').textContent;
            searchAndRedirect(plantName);
        });
    });
});

function enlargeCard() {
    this.style.transform = 'scale(1.1)';
}

function resetCard() {
    this.style.transform = 'scale(1)';
}

function getPlantImage(PlantName) {
    var lowercasePlantName = PlantName.toLowerCase();
    return imageMap.hasOwnProperty(lowercasePlantName) ? imageMap[lowercasePlantName] : 'default.jpg';
}

function searchAndRedirect(PlantName) {
    if (!PlantName) {
        console.error('Plant name is empty or undefined.');
        return;
    }

    var lowercasePlantName = PlantName.toLowerCase();
    var encodedPlantName = encodeURIComponent(PlantName);

    console.log('Encoded Plant Name:', encodedPlantName);

    window.location.href = 'result1.php?plant_name=' + encodedPlantName;
}
</script>

</body>
</html>
