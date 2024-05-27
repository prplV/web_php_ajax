<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);
    $task_id = $data['task_id'];

    try {
        $conn = require_once 'database.php';

        $sql_get_task_title = "SELECT title FROM tasks WHERE task_id = :task_id";
        $stmt_get_task_title = $conn->prepare($sql_get_task_title);
        $stmt_get_task_title->bindParam(':task_id', $task_id);
        $stmt_get_task_title->execute();
        $task_title = $stmt_get_task_title->fetchColumn();

        $sql_delete_task = "DELETE FROM tasks WHERE task_id = :task_id";
        $stmt_delete_task = $conn->prepare($sql_delete_task);
        $stmt_delete_task->bindParam(':task_id', $task_id);
        $stmt_delete_task->execute();

        $sql_delete_comments = "DELETE FROM task_comments WHERE task_id = :task_id";
        $stmt_delete_comments = $conn->prepare($sql_delete_comments);
        $stmt_delete_comments->bindParam(':task_id', $task_id);
        $stmt_delete_comments->execute();

        echo json_encode(array('success' => 'Задача "' . $task_title . '" успешно удалена'));
    } catch(PDOException $e) {
        echo json_encode(array('error' => 'Ошибка: ' . $e->getMessage()));
    }
} else {
    echo json_encode(array('error' => 'Метод запроса не поддерживается'));
}


