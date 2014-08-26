<?php

class TasksController extends Controller
{
    public function beforeAction($action)
    {
        Yii::app()->clientScript->registerCssFile('/css/non-responsive.css', 'screen, projection');
        Yii::app()->clientScript->registerScriptFile('/js/main.js');

        return parent::beforeAction($action);
    }

    public function filters()
    {
        return array(
            'accessControl'
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array(),
                'users'=>array('@')
            ),
            array('deny',
                'actions'=>array(),
                'users'=>array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        Yii::app()->clientScript->registerScriptFile('/js/notifier.js');
        Yii::app()->clientScript->registerScriptFile('/js/task_manager.js');

        $this->render('index');
    }

    public function actionAdd()
    {
        $response = array('state' => 'failed');

        if (isset($_POST['Task']))
        {
            $model = new Task();

            $model->setAttributes($_POST['Task']);
            $model->user_id = User::getLoggedUser()->id;

            if ($model->recognizeDate() && $model->validate())
            {
                $model->save();
                $response['state'] = 'success';
            }
            else
            {
                $response['errors'] = $model->getAllErrors();
            }
        }

        echo json_encode($response);
    }

    public function actionEdit()
    {
        $response = array('state' => 'failed');

        if (isset($_POST['Task']) &&
            $model = Task::model()->findByAttributes(array('user_id' => User::getLoggedUser()->id, 'id' => $_GET['id'])))
        {
            $model->setAttributes($_POST['Task']);
            $model->user_id = User::getLoggedUser()->id;

            if ($model->recognizeDate() && $model->validate())
            {
                $model->save();
                $response['state'] = 'success';
            }
            else
            {
                $response['errors'] = $model->getAllErrors();
            }
        }
        else
        {
            $response['error'] = 'ошибка сервера';
        }

        echo json_encode($response);
    }

    public function actionLoad()
    {
        $cr = new CDbCriteria();

        $cr->addCondition(':user_id = user_id');
        $cr->params = array(':user_id' => User::getLoggedUser()->id);
        $cr->order = 'date_to asc';

        $tasks = Task::model()->findAll($cr);

        echo $this->renderPartial('load', compact('tasks'), false);
    }

    public function actionClose()
    {
        if ($task = Task::model()->findByAttributes(array('user_id' => User::getLoggedUser()->id, 'id' => $_GET['id'])))
        {
            $task->close();
        }

        Yii::app()->end();
    }

    public function actionDelete()
    {
        if ($task = Task::model()->findByAttributes(array('user_id' => User::getLoggedUser()->id, 'id' => $_GET['id'])))
        {
            $task->delete();
        }

        Yii::app()->end();
    }
}