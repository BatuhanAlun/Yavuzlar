<?php
session_start();
include "functions/functions.php";

$is_company = isset($_SESSION['company_id']) ? $_SESSION['company_id'] : 'Not a Company';
$user_id = $_SESSION['id'];
$pp_path = $_SESSION["pp_path"];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (isset($_FILES['pp_path']) && $_FILES['pp_path']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['pp_path']['tmp_name'];
        $fileName = $_FILES['pp_path']['name'];
        $fileNameCmps = explode('.', $fileName);
        $fileExtension = strtolower(end($fileNameCmps));


        $allowedExts = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($fileExtension, $allowedExts)) {
            $uploadFileDir = './uploaded_files/';
            $dest_path = $uploadFileDir . $fileName;


            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                
                $pp_path = $dest_path;
            } else {
                echo 'Error moving the file to the upload directory.';
                header("location:profile.php?message=upload_error");
                exit;
            }
        } else {
            echo 'Invalid file type. Allowed file types: jpg, jpeg, png, gif.';
            header("location:profile.php?message=invalid_file");
            exit;
        }
    }

    if (!isset($pp_path)) {
        $pp_path = $_SESSION["pp_path"];
    }


    if (isset($_POST['username']) && isset($_POST['fname']) && isset($_POST['surname'])) {
        $username = $_POST['username'];
        $fname = $_POST['fname'];
        $surname = $_POST['surname'];
        

        if ($is_company !== "Not a Company") {
            updateUser($username, $fname, $surname, $user_id, $pp_path);
            $_SESSION['pp_path'] = $pp_path;
            $_SESSION["username"] = $username;
            $_SESSION["fname"] = $fname;
            $_SESSION["surname"] = $surname;
            header("location:profile.php?message=SavedCompany");
        } else {
            updateUser($username, $fname, $surname, $user_id, $pp_path);
            $_SESSION['pp_path'] = $pp_path;
            $_SESSION["username"] = $username;
            $_SESSION["fname"] = $fname;
            $_SESSION["surname"] = $surname;
            header("location:profile.php?message=SavedUser");
        }
        exit;
    }
    

    if (isset($_POST['balance']) && isset($_POST['balance_user_id'])) {
        $balance = $_POST['balance'];
        $balance_user_id = $_POST['balance_user_id'];
        addbalance($balance, $balance_user_id);
        $old_balance = $_SESSION['balance'];
        $_SESSION['balance'] = $balance + $old_balance;
        header("location:profile.php?message=BalanceUpdated");
        exit;
    }
}
?>
