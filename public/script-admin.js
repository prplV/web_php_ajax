$(document).ready(function() {
    const tasks = [
        { username: "user1", task: "Task 1", status: "active" },
        { username: "user2", task: "Task 2", status: "completed" },
        { username: "user3", task: "Task 3", status: "active" },
        { username: "user1", task: "Task 4", status: "completed" }
    ];

    function renderTasks(filteredTasks) {
        $('#task-list').empty();
        filteredTasks.forEach(task => {
            const taskItem = `
                <li class="${task.status === 'completed' ? 'completed' : ''}">
                    <span><strong>${task.username}</strong>: ${task.task}</span>
                    <div class="task-actions">
                        <button class="edit-button">Edit</button>
                        <button class="delete-button">Delete</button>
                    </div>
                </li>`;
            $('#task-list').append(taskItem);
        });
    }

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

    renderTasks(tasks);
});