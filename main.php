<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="./public/styles-main.css">
    <link rel="stylesheet" href="./public/header.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="scripts.js"></script>
    <script src="./public/main-script.js"></script>
</head>
<body>
    <div class="header">
        <h1>To-Do List</h1>
        <a href="admin.php" class="routes-header">Main</a>
        <a href="add.php" class="routes-header">Add new To-Do</a>
    </div>
    <div class="container">
        <h1>To-Do List</h1>
        <div class="task-input">
            <input type="text" id="new-task" placeholder="Add a new task">
            <button id="add-task-button">Add Task</button>
        </div>
        <div class="task-lists">
            <div class="task-list" id="active-tasks">
                <h2>Active Tasks</h2>
                <ul>
                    <!-- Active tasks will be listed here -->
                </ul>
            </div>
            <div class="task-list" id="completed-tasks">
                <h2>Completed Tasks</h2>
                <ul>
                    <!-- Completed tasks will be listed here -->
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
