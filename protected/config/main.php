<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
date_default_timezone_set('Europe/Minsk');
return array(
  'defaultController'=>'site/index',
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'DSing admin server',

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
			'password'=>'vfhf',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','192.168.10.2','::1'),
		),

	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
      'showScriptName'=>false,
			'urlFormat'=>'path',
			'rules'=>array(
        'gii'=>'gii',
        'gii/<controller:\w+>' => 'gii/<controller>',
        'gii/<controller:\w+>/<action:\w+>' => 'gii/<controller>/<action>',
        'gii/<controller:\w+>/<action:\w+>/<id:\d+>' => 'gii/<controller>/<action>',
        'login/'=>'site/login',
        'logout/'=>'site/logout',
        'index/'=>'site/index',
        'admin/'=>'users/index',
        'players/'=>'players/index',
        'update-player-tt'=>'players/set_tt',
        'groups/'=>'groups/index',
        'savegroups'=>'groups/savegroups',
        'states/'=>'states/index',
        'tt/'=>'timetables/index',
        'tt-for-adm/'=>'timetables/view',
        'ttlist'=>'timetables/get_tt_list',
        'gettt'=>'players/gettt',
        'savett'=>'timetables/save_tt',
        'getstat'=>'statistics/get_stat',
        'addstat'=>'statistics/add_stat',
        'statistics/'=>'statistics/index',
        'filelist'=>'statistics/getUserFiles',
        'ftp-credentials'=>'players/getFtpCredentials',
			),
		),

    /*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
    */
		// uncomment the following to use a MySQL database

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=dsignby_server',
			'emulatePrepare' => true,
			'username' => 'dsignby_server',
			'password' => 'boot7A#e_s',
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
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);