<?php

session_start();
include "functions/functions.php";
$user_id = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $restaurant_id = $_POST['restaurant_id'];
    $meal_name = $_POST['meal_names'];
    $meal_price = $_POST['meal_prices'];
    $meal_description = $_POST['meal_des'];
    

    $file = $_FILES['update_meal_logo'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileError = $file['error'];
    $fileSize = $file['size'];
    

    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = array('jpg', 'jpeg', 'png');
    
    if (in_array($fileExt, $allowed) && $fileError === 0 && $fileSize < 2000000) {
 
        $newFileName = uniqid('', true) . "." . $fileExt;
        $fileDestination = 'uploaded_files/' . $newFileName;
        
  
        if (move_uploaded_file($fileTmpName, $fileDestination)) {

            addmealquery($user_id,$restaurant_id,$meal_name,$meal_price,$meal_description,$fileDestination);
            header("Location:myrestaurants.php?message=Saved!");
        } else {
            header("Location:myrestaurants.php?message=Something Went Wrong!");
        }
    } else {
        eader("Location:myrestaurants.php?message=Something Went Wrong!");
    }
}
?>
