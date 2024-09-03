<?php
session_start();
include "functions/functions.php";
$user_id = $_SESSION['id'];
$ids = getQuestid($user_id);

foreach ($ids as $id):
    echo "$id";
endforeach;















?>