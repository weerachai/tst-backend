<?php
/* @var $this OControlRunningController */
/* @var $model OControlRunning */

$this->breadcrumbs=array(
	'Ocontrol Runnings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OControlRunning', 'url'=>array('index')),
	array('label'=>'Manage OControlRunning', 'url'=>array('admin')),
);
?>

<h1>Create OControlRunning</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>