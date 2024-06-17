<?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $conn = require_once "db.php";
        header('Content-Type: application/json');

        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data, true);
        if (isset($data['operation'])) {
            if ($data['operation'] == "insert") {
                $task_name = $data['name'];
                $task_description = $data['desc'];
                $task_status = $data['status'];
                $resp_ids = $data['resplist'];

                // task insert 
                $query = "INSERT INTO tasks (task, `desc`) VALUES (:taskname, :taskdesc)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':taskname', $task_name);
                $stmt->bindParam(':taskdesc', $task_description);
                $stmt->execute();
                
                // get current task id 
                $task_id = $conn->lastInsertId();
                
                // status insert 
                $query = "INSERT INTO task_status (id_task, id_status) VALUES (:taskid, :statid)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':taskid', $task_id);
                $stmt->bindParam(':statid', $task_status);
                $stmt->execute();

                // resps insert over loop 
                foreach ($resp_ids as $current_resp) {
                    $query = "INSERT INTO users_tasks (id_user, id_task) VALUES (:userid, :taskid)";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':userid', $current_resp['id']);
                    $stmt->bindParam(':taskid', $task_id);
                    $stmt->execute();
                }

                echo(json_encode(array("status" => "success")));

            } else if ($data['operation'] == "update") {

            } else if ($data['operation'] == "delete") {

            } else {
                echo(json_encode(array("status" => "error")));
            }
        } else {
            echo(json_encode(array("status" => "error")));
        }
    }
?>