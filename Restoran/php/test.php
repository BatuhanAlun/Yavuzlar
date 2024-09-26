<?php
session_start();

include "functions/functions.php";

if (isset($_POST['update_meal_discount'])) {
    $restaurant_id = $_POST['update_meal_des'];
    $new_meal_discount = $_POST['meal_discount'];
    updateMealDiscount($restaurant_id,$new_meal_discount);
    echo "5";
    header("Location:myrestaurants.php?message=Saved!");
}

?>