<?php

session_start();

include "functions/functions.php";

if (isset($_POST['fname']) && isset($_POST['surname']) && isset($_POST['username']) && isset($_POST['passwd'])) {
        $fname = htmlclean($_POST['fname']);
        $surname = htmlclean($_POST['surname']);
        $username = htmlclean($_POST['username']);
        $passwd = htmlclean($_POST['passwd']);
        $role = "company";
        registerCompany($fname,$surname,$username,$passwd,$role);
        header("Location: adminpanel.php?message=Company Saved!");
        exit();
    
}else {

    header("Location: adminpanel.php?message=Fill all the fields!");
    exit();
}













?>