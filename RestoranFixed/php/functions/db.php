<?php

$host = 'db';         
$dbname = 'php_proje';      
$uname = 'root';      
$password = 'root';

try {

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $uname, $password);


    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch (PDOException $e) {

    echo "Bağlantı hatası: " . $e->getMessage();
}
?>
