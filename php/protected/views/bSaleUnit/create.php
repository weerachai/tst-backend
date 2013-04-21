<?php
/* @var $this BSaleUnitController */
/* @var $model BSaleUnit */

$this->breadcrumbs=array(
	'Bsale Units'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BSaleUnit', 'url'=>array('index')),
	array('label'=>'Manage BSaleUnit', 'url'=>array('admin')),
);
?>

<h1>Create BSaleUnit</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>