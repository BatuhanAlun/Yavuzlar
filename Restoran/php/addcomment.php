<?php
session_start();
include "functions/functions.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
    $rating = isset($_POST['star-radio']) ? (int)$_POST['star-radio'] : null;

    if (empty($comment)) {
        header("location:menu.php?message=Fill Blanks");
    }

    if ($rating === null) {
        header("location:menu.php?message=Fill Blanks");
    }

    $user_id = $_SESSION['id'];
    $username = $_SESSION['username'];
    $res_id = $_POST['res_id'];
    addComment($user_id,$username,$res_id,$rating,$comment);
    header("location:restaurant_details.php?id=$res_id");

} else {
    header("location:menu.php?message=Something Went Wrong");
}
?>
