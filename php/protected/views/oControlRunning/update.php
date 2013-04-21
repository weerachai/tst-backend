<?php
/* @var $this OControlRunningController */
/* @var $model OControlRunning */

$this->breadcrumbs=array(
	'Ocontrol Runnings'=>array('index'),
	$model->ControlId=>array('view','id'=>$model->ControlId),
	'Update',
);

$this->menu=array(
	array('label'=>'List OControlRunning', 'url'=>array('index')),
	array('label'=>'Create OControlRunning', 'url'=>array('create')),
	array('label'=>'View OControlRunning', 'url'=>array('view', 'id'=>$model->ControlId)),
	array('label'=>'Manage OControlRunning', 'url'=>array('admin')),
);
?>

<h1>Update OControlRunning <?php echo $model->ControlId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>