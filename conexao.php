<?php

$host = "127.0.0.1";
$user = "root";
$pass = "";
$dbname = "agenda";
$port = 3306;

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=".$dbname, $user, $pass);
} catch (PDOException $err) {
    die("Error: " . $err->getMessage());
}
