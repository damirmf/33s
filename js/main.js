var taskManager = {};
var notifier = {};

$(document).ready(function(){

    taskManager = new TaskManager();
    taskManager.loadTasks();

    notifier = new Notifier();

    $('#tasks').on("click", '.task-row .edit', function(){

        var tr = $(this).parents('tr:first');

        tr.find('.edit').hide();
        tr.find('.edit-save').show();
        tr.find('.edit-cancel').show();

        tr.find('.task-text').hide();
        tr.find('.task-text-edit').show();
    });

    $('#tasks').on("click", '.task-row .edit-cancel', function(){

        var tr = $(this).parents('tr:first');

        tr.find('.edit').show();
        tr.find('.edit-save').hide();
        tr.find('.edit-cancel').hide();

        tr.find('.task-text').show();
        tr.find('.task-text-edit').hide();
    });

    $('#tasks').on("click", '.task-row .edit-save', function(){

        taskManager.editTask($(this).parents('tr:first').attr('rel'));
    });


    $('#tasks').on("click", ".task-row .close-task", function(){
        taskManager.closeTask($(this).parents('tr:first').attr('rel'));
    });

    $('#tasks').on("click", ".task-row .delete", function(){
        taskManager.deleteTask($(this).parents('tr:first').attr('rel'));
    });

    $('#task-text').keyup(function(e){

        if (e.keyCode === 13) {
            taskManager.addTask();
        }
    });

    $('.logout').click(function(){

        notifier.notify('logout', {});
    });

});