<?php
session_start();
include "functions/functions.php";

if (!isset($_SESSION['company_id'])) {
    header("location:index.php?message=You are not a business type user.");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['order_status'];

    if (empty($order_id) || empty($new_status)) {
        header("location:orders.php?message=Invalid input.");
        exit();
    }


    $result = updateOrderStatus($order_id, $new_status);

    if ($result) {
        header("location:resorder.php?message=Order status updated successfully.");
    } else {
        header("location:resorder.php?message=Failed to update order status.");
    }
    exit();
}

?>