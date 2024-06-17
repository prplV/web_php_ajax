<?php 
    // require_once "session.php";
    // $name = getLoggedInUsername();
    // if (!isset($name)) {
    //     header("Location: index.php");
    // }
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
    <script>
        $(document).ready(function() {

            $('#search-input').on('input', function() {
                const searchValue = $(this).val().toLowerCase();
                const filteredTasks = tasks.filter(task => task.username.toLowerCase().includes(searchValue));
                renderTasks(filteredTasks);
            });

            $('#task-list').on('click', '.edit-button', function() {
                const taskItem = $(this).closest('li');
                const taskText = taskItem.find('span').text().split(': ')[1];
                const newTaskText = prompt('Edit task', taskText);
                if (newTaskText) {
                    taskItem.find('span').text(taskItem.find('span').text().split(': ')[0] + ': ' + newTaskText);
                }
            });

            $('#task-list').on('click', '.delete-button', function() {
                if (confirm('Are you sure you want to delete this task?')) {
                    $(this).closest('li').remove();
                }
            });

            $('#create-button').click(function () {
                window.location.replace('add.php');
            });
            $('#users-button').click(function () {
                window.location.replace('admin-users.php');
            });
        });
    </script>
</head>
<body>
    <div class="header">
            <h1>Task Manager: admin panel (users)</h1>
            <a href="index.php" class="routes-header">Log out</a>
            <a href="admin.php" class="routes-header">Main</a>
            <a href="add.php" class="routes-header">Add new Task</a>
    </div>
    <div class="container">
        <h1>Task Manager: Admin</h1>
        <div class="search-container">
            <input type="text" id="search-input" placeholder="Search by username...">
        </div>
        <div class="task-lists">
            <div class="task-list">
                <h2>All Tasks</h2>
                <ul id="task-list">
                    <li class="">
                        
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
