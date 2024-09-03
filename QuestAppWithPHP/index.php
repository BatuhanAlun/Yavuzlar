<?php
session_start();

if (!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header("Location: loginpage.php?message=You are not logged in!");
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="main-div">
        <div class="managment-div">
            <a href=""><button class="btn-main" href>Quiz App</button></a>
        </div>
        <div class="questpage-div">
            <a href="quests.php?searchinput=&diflvl="><button class="btn-main" href>View Questions</button></a>
            <a href="skorboard.php"><button class="btn-main" href>Scoreboard</button></a>
            <a href="logout.php"><button class = "btn-main" >Log Out</button></a>
        </div>

    </div>
</body>
</html>