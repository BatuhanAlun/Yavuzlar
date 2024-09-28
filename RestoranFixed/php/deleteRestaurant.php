<?php
session_start();

include "functions/functions.php";

if (isset($_POST['restaurant_id'])){
    
    $res_id = $_POST['restaurant_id'];

    delRes($res_id);


}

header("location:myrestaurants.php?message=Succesfully Deleted");














?>