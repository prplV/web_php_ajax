<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New To-Do</title>
    <link rel="stylesheet" href="./public/header.css">
    <link rel="stylesheet" href="./public/add-styles.css">
    <script src="./public/add-script.js"></script>
</head>
    <body>
        <div class="header">
            <h1>To-Do List</h1>
            <a href="get_admin.php" class="routes-header">Main</a>
            <a href="add.php" class="routes-header">Add new To-Do</a>
        </div>
        <div class="container">
            <h1>Add New To-Do</h1>
            <form id="add-form">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="task">Task:</label>
                    <input type="text" id="task" name="task" required>
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="active">Active</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit">Add Task</button>
                </div>
            </form>
        </div>
    </body>
</html>
