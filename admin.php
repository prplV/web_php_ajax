<?php 
    require_once "session.php";
    $name = getLoggedInUsername();
    if (!isset($name)) {
        header("Location: index.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin To-Do List</title>
    <link rel="stylesheet" href="./public/styles-admin.css">
    <link rel="stylesheet" href="./public/header.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .block-cont {
            display: block;
        }
    </style>
    <script>
        $(document).ready(function() {
            var tasks = {};
            var users = {};
            var users_resp_adj = {};
            var task_status_adj = {};
            function serverRequest() {
                $.ajax({
                    method: 'post',
                    url: 'admin-getter.php',
                    contentType: "application/json; charset=utf-8",
                    data: JSON.stringify({"tasks" : "tasks"}),
                    success: function(resp) {
                        if (resp.status) {
                            alert('error db query');
                            window.location.replace('index.php');
                        } else {
                            tasks = resp.tasks;
                            users = resp.users;
                            users_resp_adj = resp.user_task_adj;
                            task_status_adj = resp.task_status_adj;
                            uploadListing(tasks);
                        }
                    }
                });
            }
            function uploadListing(_tasks) {
                const ul = $('ul');
                ul.find('li').each((index, element) => {
                    $(element).remove(); 
                });

                $.each(_tasks, (index, task) => {
                    var status;
                    var li_string;
                    $.each(task_status_adj, (id, val) => {
                        if (val.id_task == task.id) {
                            status = val.id_status;
                            return false; 
                        }
                    });
                    li_string = `<li class="${status == 1 ? '' : 'completed'}" id=${task.id}>`;
                    li_string += `<div class="block-cont"><input type="text" name="task-name" placeholder="Task name" disabled value='${task.task}'> <br>`;
                    li_string += `<input type="text" name="task-desc" placeholder="Task description" disabled value='${task.desc}'></div>`;
                    li_string += `<select name="task-status" class="task-status" disabled>`;
                    li_string += `<option value="1" ${status == 1 ? 'selected' : ''}>On-Stage</option>`;
                    li_string += `<option value="2" ${status == 2 ? 'selected' : ''}>Finished</option></select>`;
                    li_string += `<div class="task-actions"><div class="checkbox-custom">`;
                    $.each(users, (id, user) => {
                        if (id == 0) {
                            return true;
                        }
                        respst = 0;
                        $.each(users_resp_adj, (idx, resp) =>{
                            if (resp.id_user == user.id && resp.id_task == task.id) {
                                respst = 1;
                                return; 
                            }
                        });
                        if (respst == 0) {
                            li_string += `<input type="checkbox" id="${user.id}" name="${user.name}" disabled>${user.name}<br>`;
                        } else {
                            li_string += `<input type="checkbox" id="${user.id}" name="${user.name}" disabled checked>${user.name}<br>`;
                        }
                    });
                    li_string += `</div><button class="edit-button">Edit</button><button class="delete-button">Delete</button></div>`;
                    $(ul).append(li_string);
                });
            }
            
            serverRequest();

            $(document).on('change', 'select.task-status', function() {
                const li = $(this).closest('li');
                if ($(this).val() == '2') {
                    li.addClass('completed');
                } else {
                    li.removeClass('completed');
                }
            });

            //id="task-name"
            $('#search-input').on('input', function() {
                const searchValue = $(this).val().toLowerCase();
                const filteredTasks = tasks.filter(task => task.task.toLowerCase().includes(searchValue));
                uploadListing(filteredTasks);
            });

            $('#task-list').on('click', '.edit-button', function() {
                const btn = $(this);
                if (btn.text() == 'Edit') {
                    btn.text('Save');
                } else {
                    // no responsible user check 
                    // no task name check  
                    btn.text('Edit');
                    addLogEntry('Edit button clicked');
                }

                const parentBlock = $(this).parent().parent();
                parentBlock.find('input[type=text], input[type=checkbox], select').each(function() {
                    $(this).prop('disabled', !$(this).prop('disabled'));
                });
            });

            $('#task-list').on('click', '.delete-button', function() {
                if (confirm('Are you sure you want to delete this task?')) {
                    $(this).closest('li').remove();
                    addLogEntry('Delete button clicked');
                }
            });

            $('#create-button').click(function () {
                window.location.replace('add.php');
            });
            $('#users-button').click(function () {
                window.location.replace('admin-users.php');
            });


            function addLogEntry(message) {
                const logEntries = $('#log-entries');
                const timestamp = new Date().toLocaleTimeString();
                logEntries.append(`<div class="log-entry"><strong>${timestamp}</strong>: ${message}</div>`);
                logEntries.scrollTop(logEntries[0].scrollHeight);
            }
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
        <h1>Task Manager: Admin</h1>
        <div class="search-container">
            <input type="text" id="search-input" placeholder="Search by taskname...">
        </div>
        <button id="create-button" class="create-button">Create New Task</button>
        <button class="create-button" id="users-button">Users managment</button>
        <div class="task-lists">
            <div class="task-list">
                <h2>All Tasks</h2>
                <ul id="task-list">
                </ul>
            </div>
        </div>
    </div>

    <div class="log-container">
        <h2>Session Activity Log</h2>
        <div id="log-entries"></div>
    </div>
</body>
</html>
