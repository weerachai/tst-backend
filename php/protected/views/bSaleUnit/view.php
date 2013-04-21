<?php
/* @var $this BSaleUnitController */
/* @var $model BSaleUnit */

$this->breadcrumbs=array(
	'Bsale Units'=>array('index'),
	$model->SaleId,
);

$this->menu=array(
	array('label'=>'List BSaleUnit', 'url'=>array('index')),
	array('label'=>'Create BSaleUnit', 'url'=>array('create')),
	array('label'=>'Update BSaleUnit', 'url'=>array('update', 'id'=>$model->SaleId)),
	array('label'=>'Delete BSaleUnit', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->SaleId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BSaleUnit', 'url'=>array('admin')),
);
?>

<h1>View BSaleUnit #<?php echo $model->SaleId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'SaleId',
		'SaleName',
		'SaleType',
		'EmployeeId',
		'AreaId',
		'Active',
	),
)); ?>
