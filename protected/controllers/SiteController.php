<?php

class SiteController extends Controller
{
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
                'actions'=>array('login', 'error'),
                'users'=>array('*')
            ),
            array('allow',
                'actions'=>array('logout'),
                'users'=>array('@')
            ),
            array('error',
                'actions'=>array(),
                'users'=>array('*'),
            ),
            array('deny',
                'actions'=>array(),
                'users'=>array('*'),
            ),
        );
    }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
    public function actionLogin()
    {
        if (User::getLoggedUser())
            $this->redirect('/');

        $this->layout = 'auth';

        $cs = Yii::app()->clientScript;
        $cs->registerCssFile('/css/signin.css', 'screen, projection');

        $model = new LoginForm();

        if (isset($_POST['LoginForm']))
        {
            $model->setAttributes($_POST['LoginForm']);

            if ($model->validate() && $model->login())
            {
                $this->redirect('/');
            }
        }

        $this->render('login', compact('model'));
    }

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}