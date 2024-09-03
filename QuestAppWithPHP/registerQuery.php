<?php
session_start();
include "functions/functions.php";

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    header("Location: loginpage.php?message=You are already logged in!");
    die();
}


if (isset($_POST['username']) && isset($_POST['passwd']) && isset($_POST['admin'])) {
    $admin = $_POST['admin'];
    if($admin == 'admin'){
    $username = htmlclean($_POST['username']);
    $passwd = htmlclean($_POST['passwd']);
    $isadmin = 1 ;
    registerUser($username,$passwd,$isadmin);
    header("Location: loginpage.php");
    exit();
    }else{
        header("Location: register.php?message=Wrong Admin Password");
        exit();
    }
}else {
    $username = htmlclean($_POST['username']);
    $passwd = htmlclean($_POST['passwd']);
    $isadmin = 0;
    registerUser($username,$passwd,$isadmin);
    header("Location: loginpage.php");
    exit();
}






?>