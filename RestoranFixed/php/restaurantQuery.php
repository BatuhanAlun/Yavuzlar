<?php
session_start();

include "functions/functions.php";

$user_id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['restaurant_logo']) && $_FILES['restaurant_logo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['restaurant_logo']['tmp_name'];
        $fileName = $_FILES['restaurant_logo']['name'];
        $fileSize = $_FILES['restaurant_logo']['size'];
        $fileType = $_FILES['restaurant_logo']['type'];
        $fileNameCmps = explode('.', $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedExts = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($fileExtension, $allowedExts)) {
            $uploadFileDir = './uploaded_files/';
            $dest_path = $uploadFileDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
            } else {

            }
        } else {

        }
    } else {

    }
    if(isset($_POST['restaurant_name']) && isset($_POST['res_des']) && isset($_POST['meal_names']) && isset($_POST['meal_prices']) && isset($_POST['meal_des']) && !(empty($user_id))) {
        
        $restaurant_name = $_POST['restaurant_name'];
        $res_des = $_POST['res_des'];
        $meal_names = $_POST['meal_names'];
        $meal_prices = $_POST['meal_prices'];
        $meal_des = $_POST['meal_des'];


        $res_id = addRestaurant($restaurant_name,$res_des,$dest_path,$user_id);
        $meal_ids = addMeal($meal_names,$meal_prices,$meal_des,$res_id,$user_id);

        foreach ($meal_ids as $index => $meal_id){
            $fileTmpPatho = $_FILES['meal_logo']['tmp_name'][$index];
            $fileNameo = $_FILES['meal_logo']['name'][$index];
            $fileSizeo = $_FILES['meal_logo']['size'][$index];
            $fileTypeo = $_FILES['meal_logo']['type'][$index];
            $fileNameCmpso = explode('.', $fileNameo);
            $fileExtensiono = strtolower(end($fileNameCmpso));
            $allowedExtso = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($fileExtensiono, $allowedExtso)) {
            $uploadFileDiro = './uploaded_files/';
            $dest_patho = $uploadFileDiro . $fileNameo;

            if (move_uploaded_file($fileTmpPatho, $dest_patho)) {
                addMealPhoto($meal_id[$index],$dest_patho);
                header("location:restaurant.php?message=Saved!");


            } else {
                header("location:restaurant.php?message=Saved!");
            }
        } else {
            header("location:restaurant.php?message=Saved!");
        }
    
        }



    } else {

        header("location:restaurant.php?message=Fill all the blanks!");

        
    }
}


?>



