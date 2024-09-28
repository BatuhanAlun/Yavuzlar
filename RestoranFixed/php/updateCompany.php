<?php
session_start();
include "functions/functions.php";
if(isset($_POST['company_id']) && isset($_POST['company_name'])){
    echo "1";
    $company_name = $_POST['company_name'];
    $company_id = $_POST['company_id'];
    echo $company_id;
    echo $company_name;
    updateCompanyname($company_name,$company_id);
    header("location:adminpanel.php?message=Saved!");


}

?>