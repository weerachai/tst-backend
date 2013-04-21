<?php
/* @var $this BSaleUnitController */
/* @var $model BSaleUnit */

$this->breadcrumbs=array(
	'Bsale Units'=>array('index'),
	$model->SaleId=>array('view','id'=>$model->SaleId),
	'Update',
);

$this->menu=array(
	array('label'=>'List BSaleUnit', 'url'=>array('index')),
	array('label'=>'Create BSaleUnit', 'url'=>array('create')),
	array('label'=>'View BSaleUnit', 'url'=>array('view', 'id'=>$model->SaleId)),
	array('label'=>'Manage BSaleUnit', 'url'=>array('admin')),
);
?>

<h1>Update BSaleUnit <?php echo $model->SaleId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>