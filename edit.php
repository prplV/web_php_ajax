<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="./public/edit-styles.css">
    <link rel="stylesheet" href="./public/header.css">
</head>
<body>
    <div class="header">
        <h1>Task Manager: admin panel</h1>
        <a href="admin.php" class="routes-header">Main</a>
        <a href="add.php" class="routes-header">Add new Task</a>
    </div>
    <div class="container">
        <h1>Edit Task</h1>
        <form id="edit-form">
            <div class="form-group">
                <label for="task">Task:</label>
                <input type="text" id="task" name="task" placeholder="Task description goes here" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="active">Active</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            <div class="form-group">
                <label for="comment">Comment:</label>
                <input type="text" id="comment" name="comment" placeholder="Comment goes here" required>
            </div>
            <div class="form-group">
                <button type="submit">Save Changes</button>
            </div>
        </form>
    </div>
</body>
</html>
