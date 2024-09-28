<?php
session_start();

include "functions/functions.php";

if(isset($_POST['customer_id'])){
    $customer_id = $_POST['customer_id'];
    bancustomer($customer_id);
    header("location:adminpanel.php?message=User Banned");
}












?>