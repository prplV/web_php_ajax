<?php
try {
    $conn = require_once 'database.php';

    // Получаем id задачи из запроса GET
    $task_id = $_GET['task_id'];

    // Запрос для выборки задачи и всех комментариев к ней
    $sql = "SELECT t.*, c.comment_id, c.user_id AS comment_user_id, c.comment_text, c.date_created
            FROM tasks t
            LEFT JOIN comments c ON t.task_id = c.task_id
            WHERE t.task_id = :task_id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':task_id', $task_id);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo(json_encode($result,JSON_PRETTY_PRINT));
} catch(PDOException $e) {
    echo json_encode(array('error' => 'Ошибка: ' . $e->getMessage()));
}
?>
