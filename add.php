<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Task</title>
    <link rel="stylesheet" href="./public/header.css">
    <link rel="stylesheet" href="./public/add-styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('button').click(function () {
                var task = $('#task').val();
                var desc = $('#desc').val(); 
                var status = $('select').val();
                var resps = [];
                $('input[type=checkbox]:checked').each((index, element) => {
                    resps.push({'id': $(element).attr('id')});
                });
                if (task == "" || desc == "") {
                    alert(`Not all required fields are filled`);
                } else if (resps.length == 0) {
                    alert(`You need to choose not less than 1 responsible person`);
                } else {
                    $.ajax({
                        method: "post",
                        url: "tasks-manager.php",
                        contentType: "application/json; charset=utf-8",
                        data: JSON.stringify({
                            operation: 'insert',
                            name: task,
                            desc: desc,
                            status: status,
                            resplist: resps,
                        }),
                        success: function (resp) {
                            if (resp.status == 'error') {
                                alert(`Error while inserting task ${task}`);
                            } else {
                                alert(`Succesfully added task ${task}`);
                                $('#task').val("");
                                $('#desc').val("");
                                $('select option[value="1"]').prop('selected', true);
                                $('input[type=checkbox]:checked').each((index, element) => {
                                    $(element).prop('checked', false);
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
</head>
    <body>
        <div class="header">
            <h1>Task Manager: admin panel</h1>
            <a href="index.php" class="routes-header">Log out</a>
            <a href="admin.php" class="routes-header">Main</a>
            <a href="add.php" class="routes-header">Add new Task</a>
        </div>
        <div class="container">
            <h1>Add New Task</h1>
            <div id="add-form">
                <div class="form-group">
                    <label for="task">Task:</label>
                    <input type="text" id="task" name="task" required>
                </div>
                <div class="form-group">
                    <label for="task">Description:</label>
                    <input type="text" id="desc" name="desc" required>
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="1">On-Stage</option>
                        <option value="2">Finished</option>
                    </select>
                </div>
                <div class="form-group checkbox-container">
                    <label for="checkbox-custom">Responsible users:</label>
                    <div class="checkbox-custom">
                        <?php 
                            $conn = require_once "db.php";
                            $query = "SELECT u.id, u.name FROM users u;";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($users as $user) {
                                if ($user['id'] == 1) {
                                    continue;
                                }
                                echo "<input type='checkbox' id='".$user['id']."' name='".$user['name']."'>".$user['name']."<br>";
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <button>Add Task</button>
                </div>
            </div>
        </div>
    </body>
</html>
