<?php
/* @var $this BSaleAreaController */
/* @var $model BSaleArea */

$this->breadcrumbs=array(
	'Bsale Areas'=>array('index'),
	$model->AreaId=>array('view','id'=>$model->AreaId),
	'Update',
);

$this->menu=array(
	array('label'=>'List BSaleArea', 'url'=>array('index')),
	array('label'=>'Create BSaleArea', 'url'=>array('create')),
	array('label'=>'View BSaleArea', 'url'=>array('view', 'id'=>$model->AreaId)),
	array('label'=>'Manage BSaleArea', 'url'=>array('admin')),
);
?>

<h1>Update BSaleArea <?php echo $model->AreaId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>