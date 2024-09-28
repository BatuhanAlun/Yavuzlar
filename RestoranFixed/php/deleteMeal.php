<?php
session_start();

include "functions/functions.php";

if (isset($_POST['meal_id'])){
    
    $meal_id = $_POST['meal_id'];

    delMeal($meal_id);


}

header("location:myrestaurants.php?message=Succesfully Deleted");















?>