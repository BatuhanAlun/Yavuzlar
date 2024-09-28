<?php
session_start();
include "functions/functions.php";

$res_id = $_GET['id'];
$user_id = $_SESSION['id'];

if(isset($_POST['meal_id'])){
    $meal_id = $_POST['meal_id'];
    addMealtoBasket($user_id,$meal_id);

        header("Location: restaurant_details.php?id=" . $res_id);
        exit();
    } else {
        echo "Invalid meal ID";
    }

?>
