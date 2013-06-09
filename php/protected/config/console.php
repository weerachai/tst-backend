<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.

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
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),
	
	'import'=>array(
		'application.helpers.*',
	),

	// application components
	'components'=>array(
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
		
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);