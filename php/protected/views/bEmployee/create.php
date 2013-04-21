<?php
/* @var $this BEmployeeController */
/* @var $model BEmployee */

$this->breadcrumbs=array(
	'Bemployees'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BEmployee', 'url'=>array('index')),
	array('label'=>'Manage BEmployee', 'url'=>array('admin')),
);
?>

<h1>Create BEmployee</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>