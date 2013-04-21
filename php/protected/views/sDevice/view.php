<?php
/* @var $this SDeviceController */
/* @var $model SDevice */

$this->breadcrumbs=array(
	'Sdevices'=>array('index'),
	$model->DeviceId,
);

$this->menu=array(
	array('label'=>'List SDevice', 'url'=>array('index')),
	array('label'=>'Create SDevice', 'url'=>array('create')),
	array('label'=>'Update SDevice', 'url'=>array('update', 'id'=>$model->DeviceId)),
	array('label'=>'Delete SDevice', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->DeviceId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SDevice', 'url'=>array('admin')),
);
?>

<h1>View SDevice #<?php echo $model->DeviceId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'DeviceId',
		'DeviceKey',
		'SaleId',
		'Username',
		'Password',
	),
)); ?>
