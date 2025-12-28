<?php

// Local
$host = 'localhost';
$dbname = 'eticaret_db';
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Bağlantı Hatası" . $e->getMessage();
    die();
}


// Sunucu 
// $host = 'localhost';
// $dbname = 'db_121620211041';
// $username = "121620211041";
// $password = "8oE1h7bxtj4";

// try {
//     $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     echo "Bağlantı Hatası" . $e->getMessage();
//     die();
// }
?>