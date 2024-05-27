<?php
$host = 'localhost';
$username = 'hydeon';
$password = '0893';
$database = 'ToDoList';

try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $conn->exec("SET NAMES utf8");

    return $conn;
} catch(PDOException $e) {
    die("Ошибка поключения к базе данных" . $e->getMessage());
}