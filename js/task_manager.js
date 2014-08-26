var TaskManager = function()
{
	this.notifier = new Notifier();
};

TaskManager.prototype.loadTasks = function()
{
    $.ajax({
        url: '/tasks/load',
        success: function(data){
            $('#tasks tbody').html(data);
        }
    });
};

TaskManager.prototype.addTask = function()
{
    var text = $('#task-text').val();

    if (text.length > 0)
    {
        var that = this;

        $.ajax({
            url: '/tasks/add',
            type: 'POST',
            data:{
                'Task[text]':text
            },
            dataType: 'json',
            success: function(data){

                if (data.state == 'success')
                {
                    $('#task-text').val('');

                    that.loadTasks();
                    notifier.notify('reloadTask', {});
                }
                else
                {
                    alert(data.errors);
                }
            }
        });
    }
    else
    {
        alert('Текст задачи не может быть пустым');
    }
};

TaskManager.prototype.editTask = function(id)
{
    var text = $('#tasks tr[rel="'+id+'"] .task-text-edit').val();

    if (text.length > 0)
    {
        var that = this;

        $.ajax({
            url: '/tasks/edit?id=' + id,
            type: 'POST',
            data:{
                'Task[text]':text
            },
            dataType: 'json',
            success: function(data){

                if (data.state == 'success')
                {
                    that.loadTasks();
                    notifier.notify('reloadTask', {});
                }
                else
                {
                    alert(data.errors);
                }
            }
        });
    }
    else
    {
        alert('Текст задачи не может быть пустым');
    }
};

TaskManager.prototype.closeTask = function(id)
{
    var that = this;

    $.ajax({
        url: '/tasks/close',
        data:{
            'id': id
        },
        success: function(data){
            that.loadTasks();
            notifier.notify('reloadTask', {});
        }
    });
};

TaskManager.prototype.deleteTask = function(id)
{
    var that = this;

    $.ajax({
        url: '/tasks/delete',
        data:{
            'id': id
        },
        success: function(data){
            that.loadTasks();
            notifier.notify('reloadTask', {});
        }
    });
};