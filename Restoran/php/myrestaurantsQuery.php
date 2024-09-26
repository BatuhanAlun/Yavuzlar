<?php
session_start();

include "functions/functions.php";

$user_id = $_SESSION['id'];


if (isset($_POST['update_name'])) {
    $restaurant_id = $_POST['update_name'];
    $new_name = $_POST['restaurant_name'];
    updateResName($restaurant_id,$new_name);
    echo "1";
    header("Location:myrestaurants.php?message=Saved!");
    
}
if (isset($_POST['update_des'])) {
    $restaurant_id = $_POST['update_des'];
    $new_des = $_POST['res_des'];
    updateResDes($restaurant_id,$new_des);
    echo "2";
    header("Location:myrestaurants.php?message=Saved!");
}
if (isset($_POST['update_meal_name'])) {
    $restaurant_id = $_POST['update_meal_name'];
    $new_meal_name = $_POST['meal_names'];
    updateMealName($restaurant_id,$new_meal_name);
    echo "3";
    header("Location:myrestaurants.php?message=Saved!");
}
if (isset($_POST['update_meal_price'])) {
    $restaurant_id = $_POST['update_meal_price'];
    $new_meal_prices = $_POST['meal_prices'];
    updateMealPrice($restaurant_id,$new_meal_prices);
    echo "4";
    header("Location:myrestaurants.php?message=Saved!");
}
if (isset($_POST['update_meal_des'])) {
    $restaurant_id = $_POST['update_meal_des'];
    $new_meal_des = $_POST['meal_des'];
    updateMealDes($restaurant_id,$new_meal_des);
    echo "5";
    header("Location:myrestaurants.php?message=Saved!");
}
if (isset($_POST['update_meal_discount'])) {
    $restaurant_id = $_POST['update_meal_discount'];
    $new_meal_discount = $_POST['meal_discount'];
    updateMealDiscount($restaurant_id,$new_meal_discount);
    echo "5";
    header("Location:myrestaurants.php?message=Saved!");
}

if ((isset($_FILES['meal_logo']) && $_FILES['meal_logo']['error'] === UPLOAD_ERR_OK)) {
        $fileTmpPathone = $_FILES['meal_logo']['tmp_name'];
        $fileNameone = $_FILES['meal_logo']['name'];
        $fileSizeone = $_FILES['meal_logo']['size'];
        $fileTypeone = $_FILES['meal_logo']['type'];
        $fileNameCmpsone = explode('.', $fileNameone);
        $fileExtensionone = strtolower(end($fileNameCmpsone));

        $allowedExts = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($fileExtensionone, $allowedExts)) {
            $uploadFileDirone = './uploaded_files/';
             $dest_pathone = $uploadFileDirone . $fileNameone;

             if (move_uploaded_file($fileTmpPathone, $dest_pathone)) {
               echo 'File is successfully uploaded.';
               $meal_id = $_POST['update_meal_logo'];
               updateMealLogo($meal_id,$dest_pathone);
               header("Location:myrestaurants.php?message=Saved!");
        } else {
            header("Location:myrestaurants.php?message=There was some error moving the file to upload directory.");
            
            }
         } else {
            header("Location:myrestaurants.php?message=Upload failed. Allowed file types: jpg, jpeg, png, gif.");
            
        }
    } else {
        header("Location:myrestaurants.php?message=Something Went Wrong.");
}


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
               echo 'File is successfully uploaded.';
               $restaurant_id = $_POST['update_res_logo'];
               updateResLogo($restaurant_id,$dest_path);
               header("Location:myrestaurants.php?message=Saved!");
        } else {
            header("Location:myrestaurants.php?message=There was some error moving the file to upload directory.");
            
            }
         } else {
            header("Location:myrestaurants.php?message=Upload failed. Allowed file types: jpg, jpeg, png, gif.");
            
        }
    } else {
        if (isset($_FILES['meal_logo']) && $_FILES['meal_logo']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['meal_logo']['tmp_name'];
            $fileName = $_FILES['meal_logo']['name'];
            $fileSize = $_FILES['meal_logo']['size'];
            $fileType = $_FILES['meal_logo']['type'];
            $fileNameCmps = explode('.', $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
     
            $allowedExts = array('jpg', 'jpeg', 'png', 'gif');
            if (in_array($fileExtension, $allowedExts)) {
                $uploadFileDir = './uploaded_files/';
                 $dest_path = $uploadFileDir . $fileName;
     
                 if (move_uploaded_file($fileTmpPath, $dest_path)) {
                   echo 'File is successfully uploaded.';
                   $restaurant_id = $_POST['add_meal_logo'];
                   $meal_names = $_POST['meal_names'];
                   $meal_prices = $_POST['meal_prices'];
                   $meal_des = $_POST['meal_des'];

                   addMealwithLogo($meal_names,$meal_prices,$meal_des,$restaurant_id,$user_id,$dest_path);
                   
                   header("Location:myrestaurants.php?message=Saved!");
            } else {
                header("Location:myrestaurants.php?message=There was some error moving the file to upload directory.");
                
                }
             } else {
                header("Location:myrestaurants.php?message=Upload failed. Allowed file types: jpg, jpeg, png, gif.");
                
            }
        } else {
                header("Location:myrestaurants.php?message=There is no file uploaded or never tried");
        }
            
    }

}


?>



