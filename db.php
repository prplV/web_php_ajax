<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'taskmanager';

try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES utf8");
    return $conn;

} catch(PDOException $e) {

    die("Db connection error" . $e->getMessage());
}