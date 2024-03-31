
<!DOCTYPE html>
<html lang="en">
<head>
   
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="shortcut icon" type="x-icon" href="icon.png">
    <title>Ethnobotanical Database</title>
    
    <style>
        
        <?php
            session_start();

            echo "<pre>";
print_r($_SESSION);
echo "</pre>";
if (isset($_SESSION["userLoggedIn"]) && $_SESSION["userLoggedIn"] === true) {

    if (isset($_SESSION["user_type"])) {
        if ($_SESSION["user_type"] === "admin") {
            echo "Welcome, Admin!";
        } else {
            echo "Welcome, User!";
        }
    } else {
        echo "User type not found!";
    }
} else {
    echo "You are not logged in!";
}
        ?>
        body {
            font-family: Arial, sans-serif;
        }

        #search-container {
            text-align: center;
            margin: 50px;
        }

        #search-box {
            padding: 20px;
            width: 500px;
            font-size: 18px;
            box-sizing: border-box;
            background: rgb(255, 254, 254);
            border: 2px solid #fff;
            border-radius: 18px;
            color: #090909;
            outline: none;

        }

        #search-button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        #fa-search {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 25px;
            color: #fff;
            font-size: 25px;

        }
       
        #material-icons {
      width: 200px;
      height: 200px;
      font-size: 32px;
    }

        ::placeholder {
  color: rgba(123, 123, 123, 0.76);
  opacity: 1;
  font-size: 20px;
}
        body, html {
  height: 100%;
  margin: 0;
}

body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: url('img3.jpg') center/cover no-repeat; 
        }

        .search-container {
            text-align: center;
        }

        .search-bar {
            padding: 10px;
            width: 300px; 
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .webkit-input-placeholder{
            color: #fff;
        }
       i {
        position: absolute;
        top: 46%;
        color: rgb(255, 252, 252);
       } 
       
.bg {
  background-image: url("images1.jpg");

  height: 100%; 

  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}
        #plantButton {
            position: fixed;
            top: 0;
            left: 0;
            margin: 10px;
            padding: 10px;
            background-color: #abcdef; 
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        h1 {
            float: middle;
            position: absolute;
            top: 35%;
            color: white;
        }
        #aboutus {
            position: fixed;
    bottom: 5px;
    right: 15px;
    padding: 10px;
    background-color: rgba(76, 175, 80, 0.7); 
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    background-color: rgba(69, 160, 73, 0.7);
}
#orangasli {
            position: fixed;
    bottom: 5px;
    right: 90px;
    padding: 10px;
    background-color: rgba(76, 175, 80, 0.7); 
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    background-color: rgba(69, 160, 73, 0.7);
}
#geographic {
    position: fixed;
    bottom: 5px;
    right: 170px;
    padding: 10px;
    background-color: rgba(76, 175, 80, 0.7); 
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    background-color: rgba(69, 160, 73, 0.7);
}
#link {
    position: fixed;
    bottom: 5px;
    right: 340px;
    padding: 10px;
    background-color: rgba(76, 175, 80, 0.7); 
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    background-color: rgba(69, 160, 73, 0.7);
}
#visitorCount {
    margin-top: 10px;
    font-size: 20px;
    position: absolute;
    bottom: 100px; 
    left: 50%;
    transform: translateX(-50%);
    color: rgb(0, 0, 0);
    background-color: rgba(255, 255, 255, 0.7); 
    padding: 10px;
    border-radius: 5px;
}
#login {
    position: fixed;
    top: 0;
    right: 0; 
    margin: 10px;
    padding: 10px;
    background-color: #abcdef; 
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}
#logout {
    position: fixed;
    top: 0;
    right: 0; 
    margin: 10px;
    padding: 10px;
    background-color: #abcdef; 
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}
#news {
    position: fixed;
    bottom: 5px;
    right: 420px;
    padding: 10px;
    background-color: rgba(76, 175, 80, 0.7); 
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    background-color: rgba(69, 160, 73, 0.7);
}
#feedback {
    position: fixed;
    bottom: 5px;
    right: 474px;
    padding: 10px;
    background-color: rgba(76, 175, 80, 0.7); 
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    background-color: rgba(69, 160, 73, 0.7);
}
#requestButton {
    position: fixed;
    bottom: 5px;
    padding: 10px;
    background-color: rgba(76, 175, 80, 0.7); 
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    background-color: rgba(69, 160, 73, 0.7);
}
 </style>
</head>
<body onload="checkLogin()">
    <h1>Useful Plants of Orang Asli in Peninsula Malaysia</h1>
    <button id="plantButton" onclick="location.href='allplant1.php'">All Plants</button>
    <button id="login" onclick="location.href='login.html'">Login</button>
    <button id="logout" onclick="logout()">Log Out</button>
    <button id="aboutus" onclick="location.href='aboutus.html'">About Us</button>
    <button id="orangasli" onclick="location.href='orangasli.html'">Orang Asli</button>   
    <button id="geographic" onclick="location.href='geographicaldistribution.html'">Geographical Distribution</button>   
    <button id="link" onclick="location.href='clickablelink.html'">Useful Link</button>   
    <button id="news" onclick="location.href='news.html '">News</button>   
    <button id="feedback" onclick="location.href='feedback.html '">Feedback</button>  
    </div>
    <div class="bg"></div>

    <form action="result1.php" onsubmit="return false;">
        <div id="search-container">
            <input type="text" id="search-box" name="plant_name" placeholder="Enter plant name" autocomplete="off">
            <i class="material-icons" onclick="submitForm()" style="font-size: 50px">search</i>
        </div>
    </form>
    <?php 
    if(isset($_SESSION["userLoggedIn"]) && $_SESSION["userLoggedIn"] === true && isset($_SESSION["user_type"]) && $_SESSION["user_type"] === "admin"): ?>
        <button id="requestButton" onclick="location.href='request_page.php'" style="position: fixed; bottom: 10px; left: 10px;">Request</button>
    <?php endif; ?>

<script>
    function checkLogin(userLoggedIn) {
            if (userLoggedIn) {
                <?php if (isset($_SESSION["user_type"])) : ?>
                    <?php if ($_SESSION["user_type"] === "admin") : ?>
                        document.write("<button id='logout' onclick='logout()'>Log Out</button>");
                    <?php endif; ?>
                <?php endif; ?>
            } else {
            }
        }
      document.getElementById("search-box").addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            submitForm();
        }
    });
    function logout() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'logout.php', true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            window.location.href = 'FYP.html';
        } else {
            console.error('Logout request failed.');
        }
    };

    xhr.send();
}

    function submitForm() {
            var plantName = document.getElementById('search-box').value.toLowerCase();
            if (plantName.trim() !== '') {
                window.location.href = 'result1.php?plant_name=' + encodeURIComponent(plantName);
            } else {
                alert('Please enter a plant name.');
            }
        }
    function incrementAndDisplayCount() {
            if (localStorage.getItem('visitorCount')) {
                let count = parseInt(localStorage.getItem('visitorCount'));
                count++;
                localStorage.setItem('visitorCount', count);
            } else {
                localStorage.setItem('visitorCount', 1);
            }

            const visitorCountElement = document.getElementById('visitorCount');
            visitorCountElement.textContent = 'You have visit this page ' + localStorage.getItem('visitorCount') + ' ' + 'times';
        }
        window.onload = incrementAndDisplayCount;
function materialicons() {
    var searchTerm = document.getElementById("search-box").value.toLowerCase();
    var searchResults = document.getElementById("search-container");
    searchResults.innerHTML = '';

    if (searchTerm === "page1") {
        window.location.href = 'page1';
    } else if (searchTerm === "page2") {
        window.location.href = 'page2.html';
    } else if (searchTerm === "pokok kees") {
        window.location.href = 'pokok kees.html';
    } else if (searchTerm === "durian biasa") {
        window.location.href = 'DB.html';
    } else if (searchTerm === "labu bulat") {
        window.location.href = 'labu bulat.html';
    } else {
        alert("The plant that you searching for is not located in Pennisula Malaysia");
    }
}
    function navigateToAboutUsPage() {
            window.location.href = 'aboutus.html'; 
        }
</script>

<div id="visitorCount"></div>
</body>
</html>