<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

$OPENSHIFT_MYSQL_DB_HOST = getenv("OPENSHIFT_MYSQL_DB_HOST");
if (empty($OPENSHIFT_MYSQL_DB_HOST)) {
   $OPENSHIFT_MYSQL_DB_HOST = 'localhost';
   $OPENSHIFT_MYSQL_USERNAME = 'root';
   $OPENSHIFT_MYSQL_PASSWORD = '1234';
} else {
   $OPENSHIFT_MYSQL_USERNAME = 'adminTbebzg2';
   $OPENSHIFT_MYSQL_PASSWORD = 'lKkp4SIWiue9';
}

return array(
//	'theme'=>'abound',
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Total Sales Tools - Backend',

	// preloading 'log' component
	'preload'=>array('log','bootstrap'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.helpers.*',
		'application.helpers.reports.*',
		'application.extensions.crontab.*',
		'ext.giix-components.*', // giix components
		'application.vendors.phpexcel.PHPExcel',
		'ext.yiireport.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'manage','data','report','master',
		'backup',
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'generatorPaths' => array(
				'ext.giix-core', // giix generators
				'bootstrap.gii',
			),
			'password'=>false,
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('192.168.1.*','::1'),
		),
		
	),

	// application components
	'components'=>array(
      		'user'=>array(
			// enable cookie-based authentication
				'allowAutoLogin'=>true,
			),
      		'bootstrap' => array(
	    		'class' => 'ext.bootstrap.components.Bootstrap',
	    		'responsiveCss' => true,
			),
                
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
        */
                /*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
                */
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => "mysql:host=$OPENSHIFT_MYSQL_DB_HOST;dbname=backend",
			'emulatePrepare' => true,
			'username' =>  $OPENSHIFT_MYSQL_USERNAME,
			'password' =>  $OPENSHIFT_MYSQL_PASSWORD,
			'charset' => 'utf8',
		),

                'authManager'=>array(
                        'class'=>'CDbAuthManager',
                        'connectionID' => 'db',
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