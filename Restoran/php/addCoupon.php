<?php

session_start();

include "functions/functions.php";



if(isset($_POST['coupon_name'])&& isset($_POST['percentage'])){

    $coupon_name = $_POST['coupon_name'];
    $percentage = $_POST['percentage']/100;

    addCoupon($coupon_name,$percentage);
    header("location:adminpanel.php?message=Coupon added Coupon Name = $coupon_name");

}

if(isset($_POST['coupon_id'])){

    $coupon_id = $_POST['coupon_id'];

    deleteCoupon($coupon_id);
    header("location:adminpanel.php?message=Coupon deleted Coupon id = $coupon_id");

}







?>