<?php /** @var CActiveForm $form */ $form=$this->beginWidget('CActiveForm', array(
    'id'=>'login-form',
    'enableAjaxValidation'=>false,
    'htmlOptions' => array('class' => 'form-signin'),
    'clientOptions' => array(
        'errorCssClass' => 'has-error',
    ),
)); ?>

    <h2 class="form-signin-heading">Вход в систему</h2>
    <?php echo $form->textField($model, 'username',
        array('class' => 'form-control', 'placeholder' => 'email')); ?>
    <?= $form->error($model, 'username'); ?>

    <?php echo $form->passwordField($model, 'password',
        array('class' => 'form-control b-signin__control', 'placeholder' => 'пароль')); ?>
    <?= $form->error($model, 'username'); ?>

    <?php echo CHtml::submitButton('Войти', array('class' => 'btn btn-lg btn-primary btn-block')); ?>
<?php $this->endWidget(); ?>