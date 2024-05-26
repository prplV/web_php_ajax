<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin To-Do List</title>
    <link rel="stylesheet" href="./public/styles-admin.css">
    <link rel="stylesheet" href="./public/header.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./public/script-admin.js"></script>
</head>
<body>
    <div class="header">
        <h1>To-Do List</h1>
        <a href="admin.php" class="routes-header">Main</a>
        <a href="add.php" class="routes-header">Add new To-Do</a>
    </div>
    <div class="container">
        <h1>Admin To-Do List</h1>
        <div class="search-container">
            <input type="text" id="search-input" placeholder="Search by username...">
        </div>
        <button id="create-button" class="create-button">Create New To-Do</button>
        <div class="task-lists">
            <div class="task-list">
                <h2>All Tasks</h2>
                <ul id="task-list">
                    <!-- Tasks will be dynamically inserted here -->
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
