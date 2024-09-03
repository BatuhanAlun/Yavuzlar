<?php
session_start();

include "functions/functions.php";

if(!isset($_POST['username']) || !isset($_POST['passwd'])) {
    header("Location: loginpage.php?message=Username and password must filled!");
    die();
}else {
    $username = htmlclean($_POST['username']);
    $passwd = htmlclean($_POST['passwd']);
    

    $result = login($username,$passwd,);
    $rowCount = $result['count'];

    if($rowCount == 1){

        $_SESSION["id"] = $result["id"];
        $_SESSION["username"] = $result["username"];
        $_SESSION["isAdmin"] = $result["isAdmin"];

        
        header("Location:index.php?message=Successful login!");
        
        exit();
    }else{
        
        header("Location:loginpage.php?message=Wrong password or username!");
        
        exit();
    }


    



}










?>