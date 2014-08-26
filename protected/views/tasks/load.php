<?php /** @var $task Task */ foreach($tasks as $task): ?>
    <tr class="task-row" rel="<?= $task->id; ?>">
        <td><?= $task->date_to; ?></td>
        <td<?= $task->is_closed ? ' style="text-decoration:line-through"' :
            ($task->isOverdue() ? ' style="background-color:red"' : '') ?>>
            <span class="task-text"><?= $task->text; ?></span>
            <input type="text" value="<?= $task->text; ?>" style="display: none; width: 450px" class="task-text-edit" />
            <a class="btn btn-sm btn-success edit-save" style="display: none;">сохранить</a>
            <a class="btn btn-sm btn-default edit-cancel" style="display: none;">отмена</a>
        </td>
        <td>
            <?php if (!$task->is_closed): ?>
            <a class="btn btn-sm btn-warning close-task">выполнено</a>
                <a class="btn btn-sm btn-primary edit">ред.</a>
            <?php endif;?>
            <a class="btn btn-sm btn-danger delete">удал.</a>
        </td>
    </tr>
<?php endforeach; ?>