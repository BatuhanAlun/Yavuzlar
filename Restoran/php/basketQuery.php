<?php
session_start();
include "functions/functions.php";


if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];
$balance = $_SESSION['balance'];
$total_price = $_POST['final_price'];
$c_id = $_POST['c_id'];
$notes = $_POST['note'];


if ($total_price > $balance) {
    header("Location: basket.php?message=Insufficient funds");
    exit();
}


$_SESSION['balance'] = $balance - $total_price;
$balance = $_SESSION['balance'];


if (!empty($c_id)) {
    markCoupon($user_id, $c_id);
}


updateBalance($user_id, $balance);


$order_id = openOrder($user_id, $total_price, $notes);
clearBasket($user_id);


header("Location: order_confirmation.php?order_id=$order_id");
exit();



?>
