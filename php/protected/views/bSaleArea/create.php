<?php
/* @var $this BSaleAreaController */
/* @var $model BSaleArea */

$this->breadcrumbs=array(
	'Bsale Areas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BSaleArea', 'url'=>array('index')),
	array('label'=>'Manage BSaleArea', 'url'=>array('admin')),
);
?>

<h1>Create BSaleArea</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>