<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'db'=>array(
				'connectionString' => 'mysql:host=mysql.hostinger.ru;dbname=u256929599_s',
				'emulatePrepare' => true,
				'username' => 'u256929599_slon',
				'password' => 'slon123',
				'charset' => 'utf8',
			),
		),
	)
);
