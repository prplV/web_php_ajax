<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из тела POST-запроса и декодируем JSON
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);

    // Проверяем, были ли успешно декодированы JSON-данные
    if ($data !== null) {
        $task_id = $data['task_id'];
        $new_title = $data['title'];
        $new_description = $data['description'];
        $new_due_date = $data['due_date'];
        $new_responsible_users = $data['responsible_users'];

        try {
            // Подключаемся к базе данных
            $conn = require_once 'database.php';

            // Получаем информацию о старой задаче
            $sql_get_old_task = "
                SELECT t.title AS old_title, t.description AS old_description, t.due_date AS old_due_date,
                GROUP_CONCAT(u.username SEPARATOR ', ') AS old_responsible_users
                FROM tasks t
                LEFT JOIN task_responsible_users tru ON t.task_id = tru.task_id
                LEFT JOIN users u ON tru.user_id = u.user_id
                WHERE t.task_id = :task_id
                GROUP BY t.task_id
            ";
            $stmt_get_old_task = $conn->prepare($sql_get_old_task);
            $stmt_get_old_task->bindParam(':task_id', $task_id);
            $stmt_get_old_task->execute();
            $old_task = $stmt_get_old_task->fetch(PDO::FETCH_ASSOC);

            // Получаем имена новых ответственных пользователей

            // Обновляем остальные данные задачи
            $sql_update_task = "
                UPDATE tasks 
                SET title = :title, description = :description, due_date = :due_date 
                WHERE task_id = :task_id
            ";
            $stmt_update_task = $conn->prepare($sql_update_task);
            $stmt_update_task->bindParam(':title', $new_title);
            $stmt_update_task->bindParam(':description', $new_description);
            $stmt_update_task->bindParam(':due_date', $new_due_date);
            $stmt_update_task->bindParam(':task_id', $task_id);
            $stmt_update_task->execute();

            // Удаляем старых ответственных пользователей для данной задачи
            $sql_delete_old_responsible_users = "
                DELETE FROM task_responsible_users 
                WHERE task_id = :task_id
            ";
            $stmt_delete_old_responsible_users = $conn->prepare($sql_delete_old_responsible_users);
            $stmt_delete_old_responsible_users->bindParam(':task_id', $task_id);
            $stmt_delete_old_responsible_users->execute();

            // Добавляем новых ответственных пользователей для данной задачи
            $sql_insert_new_responsible_users = "
                INSERT INTO task_responsible_users (task_id, user_id) 
                VALUES (:task_id, :user_id)
            ";

            $stmt_insert_new_responsible_users = $conn->prepare($sql_insert_new_responsible_users);
            foreach ($new_responsible_users as $user_id) {
                $stmt_insert_new_responsible_users->bindParam(':task_id', $task_id);
                $stmt_insert_new_responsible_users->bindParam(':user_id', $user_id);
                $stmt_insert_new_responsible_users->execute();
            }
            $sql_get_new_responsible_users_names = "
                SELECT GROUP_CONCAT(u.username SEPARATOR ', ') AS responsible_users_names
                FROM task_responsible_users tru
                LEFT JOIN users u ON tru.user_id = u.user_id
                WHERE tru.task_id = :task_id
            ";
            $stmt_get_new_responsible_users_names = $conn->prepare($sql_get_new_responsible_users_names);
            $stmt_get_new_responsible_users_names->bindParam(':task_id', $task_id);
            $stmt_get_new_responsible_users_names->execute();
            $new_responsible_users_names = $stmt_get_new_responsible_users_names->fetchColumn();

            // Выводим информацию о задаче в JSON формате
            echo json_encode(array(
                'old_task' => array(
                    'task_id' => $task_id,
                    'title' => $old_task['old_title'],
                    'description' => $old_task['old_description'],
                    'due_date' => $old_task['old_due_date'],
                    'responsible_users' => $old_task['old_responsible_users'],
                ),
                'new_task' => array(
                    'task_id' => $task_id,
                    'title' => $new_title,
                    'description' => $new_description,
                    'due_date' => $new_due_date,
                    'responsible_users' => $new_responsible_users_names,
                    'responsible_users_id' => $data['responsible_users']
                )
            ));
        } catch(PDOException $e) {
            // Возвращаем JSON-ответ с сообщением об ошибке
            echo json_encode(array('error' => 'Ошибка: ' . $e->getMessage()));
        }
    } else {
        // Возвращаем JSON-ответ с сообщением об ошибке, если не удалось декодировать JSON-данные
        echo json_encode(array('error' => 'Ошибка при декодировании JSON-данных'));
    }
} else {
    // Возвращаем JSON-ответ с сообщением об ошибке, если это не POST-запрос
    echo json_encode(array('error' => 'Метод запроса не поддерживается'));
}

?>
