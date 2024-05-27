<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);

    if ($data !== null) {
        $title = $data['title'];
        $description = $data['description'];
        $due_date = $data['due_date'];
        $responsible_users = $data['responsible_users'];
        try {
            $conn = require_once 'database.php';

            $sql = "INSERT INTO tasks (title, description, due_date) VALUES (:title, :description, :due_date)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':due_date', $due_date);
            $stmt->execute();
            $task_id = $conn->lastInsertId();

            $sql_responsible_users = "INSERT INTO task_responsible_users (task_id, user_id) VALUES (:task_id, :user_id)";
            $stmt_responsible_users = $conn->prepare($sql_responsible_users);

            foreach ($responsible_users as $user_id) {
                $stmt_responsible_users->bindParam(':task_id', $task_id);
                $stmt_responsible_users->bindParam(':user_id', $user_id);
                $stmt_responsible_users->execute();
            }

            echo json_encode(array('success' => 'Задача успешно добавлена'));
        } catch(PDOException $e) {
            echo json_encode(array('error' => 'Ошибка: ' . $e->getMessage()));
        }
    } else {
        echo json_encode(array('error' => 'Ошибка при декодировании JSON-данных'));
    }
} else {
    echo json_encode(array('error' => 'Метод запроса не поддерживается'));
}

