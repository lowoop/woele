<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'I\'m hungry',
	'language'=>'zh_cn',
    'timeZone'=>'Australia/Melbourne',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'111111',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'adm',
	),

	// application components
	'components'=>array(
		'coreMessages'=>array(
			'basePath'=>'protected/messages',
		),
		'user'=>array(
			// enable cookie-based authentication
			'class'=>'WebUser',
			'allowAutoLogin'=>true,
			//'stateKeyPrefix'=>'lo',
			'authTimeout'=>'86400',
			'loginUrl' => array('site/login'),
		),
		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
            //'caseSensitive' => true,
			'rules'=>array(
				'login'										=>	'site/login',
				'logout'									=>	'site/logout',
				'register'									=>	'user/register',
				'settings'									=>	'user/update',
				'<controller:\w+>/<id:\d+>'					=>	'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'	=>	'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'				=>	'<controller>/<action>',
			),
		),

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=admin_default',
			'emulatePrepare' => true,
			'username' => 'admin_default',
			'password' => 'mFMXuVZLUf112543',
			'charset' => 'utf8',
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'Smtpmail'=>array(
				'class'=>'ext.smtpmail.PHPMailer',
// 				'Host'=>"smtp.126.com",
// 				'Username'=>'lowoop@126.com',
// 				'Password'=>'soeasy',
				'Mailer'=>'smtp',
// 				'Port'=>25,
				'SMTPAuth'=>true,
		),
	),
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);