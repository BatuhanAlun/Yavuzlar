<?php
session_start();

include "functions/functions.php";

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    header("Location: login.php?message=You are already logged in!");
    die();
}

if (isset($_POST['fname']) && isset($_POST['surname']) && isset($_POST['username']) && isset($_POST['passwd']) && isset($_POST['role'])) {
    $role = $_POST['role'];
    if($role == 'user'){
    $fname = htmlclean($_POST['fname']);
    $surname = htmlclean($_POST['surname']);
    $username = htmlclean($_POST['username']);
    $passwd = htmlclean($_POST['passwd']);
    registerUser($fname,$surname,$username,$passwd,$role);
    header("Location: login.php");
    exit();
    }else{
        $fname = htmlclean($_POST['fname']);
        $surname = htmlclean($_POST['surname']);
        $username = htmlclean($_POST['username']);
        $passwd = htmlclean($_POST['passwd']);
        registerCompany($fname,$surname,$username,$passwd,$role);
        header("Location: login.php");
        exit();
    }
}else {

    header("Location: login.php?message=Fill all the fields!");
    exit();
}




?>