<?php
try {
    $conn = require_once 'database.php';

    $sql = "SELECT t.*, GROUP_CONCAT(u.username) AS responsible_users, GROUP_CONCAT(u.user_id) AS responsible_users_id
            FROM tasks t
            LEFT JOIN task_responsible_users tru ON t.task_id = tru.task_id
            LEFT JOIN users u ON tru.user_id = u.user_id
            GROUP BY t.task_id";

    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo(json_encode($result,JSON_PRETTY_PRINT));
} catch(PDOException $e) {
    echo json_encode(array('error' => 'Ошибка: ' . $e->getMessage()));
}
?>
