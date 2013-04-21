<?php
/* @var $this SDeviceController */
/* @var $model SDevice */

$this->breadcrumbs=array(
	'Sdevices'=>array('index'),
	$model->DeviceId=>array('view','id'=>$model->DeviceId),
	'Update',
);

$this->menu=array(
	array('label'=>'List SDevice', 'url'=>array('index')),
	array('label'=>'Create SDevice', 'url'=>array('create')),
	array('label'=>'View SDevice', 'url'=>array('view', 'id'=>$model->DeviceId)),
	array('label'=>'Manage SDevice', 'url'=>array('admin')),
);
?>

<h1>Update SDevice <?php echo $model->DeviceId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>