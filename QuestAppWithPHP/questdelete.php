<?php
session_start();
include "functions/functions.php";
$is_admin = $_SESSION["isAdmin"];
if ($is_admin == 0){
    header("Location:index.php?message=You Dont Have Permission");
}
$questionid = $_GET["id"];

deleteQuestion($questionid);

header("Location:quests.php?searchinput=&diflvl=");
exit();

?>