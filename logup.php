<?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data, true);
        
        $name = $data["username"];
        $pswd = $data["password"];

        $conn = require_once "db.php";

        $query = "
            SELECT * FROM users u 
            WHERE u.name = :name AND u.pswd = :pswd
            LIMIT 1;
        ";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':pswd', $pswd);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');

        if ($user) {
            echo(json_encode(array("status" => "error")));
        } 
        else {
            // echo(json_encode(array("status" => "error")));
            $query = "
            INSERT INTO users(name, pswd) 
            VALUES (:name, :pswd);
            ";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':pswd', $pswd);
            $stmt->execute();
            echo(json_encode(array("status" => "success")));
        }

    } else {
        echo(json_encode(array("status" => "error")));
    }
?>