$(document).ready(function() {
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
