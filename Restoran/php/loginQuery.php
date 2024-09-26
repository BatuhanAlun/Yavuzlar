<?php
session_start();

include "functions/functions.php";


if(!isset($_POST['username']) || !isset($_POST['passwd'])) {
    header("Location: loginpage.php?message=Username and password must be filled!");
    die();
} else {
    
    $username = htmlclean($_POST['username']);
    $passwd = htmlclean($_POST['passwd']);

    
    $result = login($username, $passwd);


    if($result) { 
        
        $_SESSION["id"] = $result["id"];
        $_SESSION["username"] = $result["username"];
        $_SESSION["fname"] = $result["fname"];
        $_SESSION["surname"] = $result["surname"];
        $_SESSION["company_id"] = $result["company_id"];
        $_SESSION["balance"] = $result["balance"];
        $_SESSION["is_admin"] = $result["is_admin"];
        $_SESSION["deleted_at"] = $result["deleted_at"];
        $_SESSION["pp_path"] = $result["pp_path"];
        $_SESSION["rolee"] = $result["rolee"];


       
        header("Location: index.php?message=Successful login!");
        exit();
    } else {
        
        header("Location: login.php?message=Wrong password or username!");
        exit();
    }
}
?>