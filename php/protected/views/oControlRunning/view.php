<?php
/* @var $this OControlRunningController */
/* @var $model OControlRunning */

$this->breadcrumbs=array(
	'Ocontrol Runnings'=>array('index'),
	$model->ControlId,
);

$this->menu=array(
	array('label'=>'List OControlRunning', 'url'=>array('index')),
	array('label'=>'Create OControlRunning', 'url'=>array('create')),
	array('label'=>'Update OControlRunning', 'url'=>array('update', 'id'=>$model->ControlId)),
	array('label'=>'Delete OControlRunning', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ControlId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OControlRunning', 'url'=>array('admin')),
);
?>

<h1>View OControlRunning #<?php echo $model->ControlId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'ControlId',
		'ControlName',
		'Prefix',
		'UpdateAt',
	),
)); ?>
