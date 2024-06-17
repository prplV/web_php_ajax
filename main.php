<?php 
    // if (!$_SESSION['username'] || $_SESSION['username'] == "") {
    //     header("Location: index.php");
    // }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="./public/styles-main.css">
    <link rel="stylesheet" href="./public/header.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('document').ready(function() {
            function addTask(taskText, isCompleted) {
                const task = $('<li class="taskbar"></li>').text(taskText);
                const completeButton = $('<button></button>').text('Complete').click(function() {
                    $(this).parent().appendTo('#completed-tasks ul').addClass('completed');
                    $(this).remove();
                });
                const deleteButton = $('<button></button>').text('Delete').click(function() {
                    $(this).parent().remove();
                });
                
                task.append(completeButton).append(deleteButton);
                
                if (isCompleted) {
                    task.appendTo('#completed-ttasks ul').addClass('completed');
                    completeButton.remove();
                } else {
                    task.appendTo('#active-tasks ul');
                }
            }
            $('li').on('click', function () {
                alert();
            });
            $('#add-task-button').click(function() {
                const taskText = $('#new-task').val();
                if (taskText) {
                    addTask(taskText, false);
                    $('#new-task').val('');
                }
            });
            const tasks = [
                { text: 'Buy groceries', completed: false },
                { text: 'Walk the dog', completed: true },
                { text: 'Read a book', completed: false }
            ];
            tasks.forEach(task => addTask(task.text, task.completed));
        });
    </script>
</head>
<body>
    <div class="header">
        <a href="index.php" class="routes-header">Log out</a>
    </div>
    <div class="container">
        <h1>Task Manager</h1>
        <div class="task-input">
            <input type="text" id="new-task" placeholder="Add a new task">
            <button id="add-task-button">Add Task</button>
        </div>
        <div class="task-lists">
            <div class="task-list" id="active-tasks">
                <h2>Active Tasks</h2>
                <ul>
                </ul>
            </div>
            <div class="task-list" id="completed-tasks">
                <h2>Completed Tasks</h2>
                <ul>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
