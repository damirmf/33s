<?php
error_reporting(E_ERROR);
ini_set("display_errors", 1);
// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yii.php';
require_once dirname(__FILE__).'/protected/config/env.php';
$config=dirname(__FILE__).'/protected/config/'.$env.'.php';

// remove the following line when in production mode
// defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);
Yii::createWebApplication($config)->run();
