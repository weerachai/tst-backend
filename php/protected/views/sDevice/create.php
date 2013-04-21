<?php
/* @var $this SDeviceController */
/* @var $model SDevice */

$this->breadcrumbs=array(
	'Sdevices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SDevice', 'url'=>array('index')),
	array('label'=>'Manage SDevice', 'url'=>array('admin')),
);
?>

<h1>Create SDevice</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>