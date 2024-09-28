<?php
session_start();


include "functions/functions.php";

$res_id = 1;

$average = getAverageScore($res_id);

echo $average;

?>



