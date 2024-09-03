<?php
include "functions/functions.php";
session_start();

if (isset($_POST['questname']) && isset($_POST['selection1']) && isset($_POST['selection2']) && isset($_POST['selection3']) && isset($_POST['selection4']) && isset($_POST['correctanswer']) && isset($_POST['diflvl'])) {
    $questname = htmlclean($_POST['questname']);
    $selection1 = htmlclean($_POST['selection1']);
    $selection2 = htmlclean($_POST['selection2']);
    $selection3 = htmlclean($_POST['selection3']);
    $selection4 = htmlclean($_POST['selection4']);
    $correctanswer = ($_POST['correctanswer']);
    $diflvl = ($_POST['diflvl']);
    registerQuestion($questname,$selection1,$selection2,$selection3,$selection4,$correctanswer,$diflvl);
    header("Location: quests.php?searchinput=&diflvl=");
    exit();
}

?>