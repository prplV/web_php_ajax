<?php 

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $conn = require_once "db.php";
        header('Content-Type: application/json');

        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data, true);

        if (isset($data["tasks"])) {
            // get users array 
            $query = "SELECT u.id, u.name FROM users u;";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // get users' responsibility array  
            $query1 = "SELECT * FROM `users_tasks` LIMIT 0 , 30 ";
            $stmt1 = $conn->prepare($query1);
            $stmt1->execute();
            $users_resp = $stmt1->fetchAll(PDO::FETCH_ASSOC);

            // get task_status array
            $query2 = "
            SELECT * FROM task_status;
            ";
            $stmt2 = $conn->prepare($query2);
            $stmt2->execute();
            $task_status = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            // get tasks array 
            $query3 = "
            SELECT t.id, t.task, t.desc FROM tasks t;
            ";
            $stmt3 = $conn->prepare($query3);
            $stmt3->execute();
            $tasks = $stmt3->fetchAll(PDO::FETCH_ASSOC);

            // preproccessing 

            $response = json_encode(array(
                "users" => $users,
                "tasks" => $tasks,
                "user_task_adj" => $users_resp,
                "task_status_adj" => $task_status,
            ));

            // sending request 
            echo $response;

        } else if (isset($data["users"])) {
            //
        } else {
            echo(json_encode(array("status" => "error")));
        }
    }

?>