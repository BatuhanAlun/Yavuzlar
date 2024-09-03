<?php
session_start();

include "functions/functions.php";

if(isset($_POST['questname']) && isset($_POST['selection1']) && isset($_POST['selection2']) && isset($_POST['selection3']) && isset($_POST['selection4'])) {

    $questionid = $_GET["id"];
    $questname = htmlclean($_POST['questname']);
    $selection1 = htmlclean($_POST['selection1']);
    $selection2 = htmlclean($_POST['selection2']);
    $selection3 = htmlclean($_POST['selection3']);
    $selection4 = htmlclean($_POST['selection4']);
    editQuestion($questname,$selection1,$selection2,$selection3,$selection4,$questionid);
    header("Location: quests.php?searchinput=&diflvl=");
    exit();
}







?>