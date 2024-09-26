<?php
include "functions/functions.php";
session_start();
$user_id = $_SESSION['id'];


session_destroy();

echo "session succesfuly destroyed";



?>