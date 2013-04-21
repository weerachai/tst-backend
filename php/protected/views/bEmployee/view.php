<?php
/* @var $this BEmployeeController */
/* @var $model BEmployee */

$this->breadcrumbs=array(
	'Bemployees'=>array('index'),
	$model->EmployeeId,
);

$this->menu=array(
	array('label'=>'List BEmployee', 'url'=>array('index')),
	array('label'=>'Create BEmployee', 'url'=>array('create')),
	array('label'=>'Update BEmployee', 'url'=>array('update', 'id'=>$model->EmployeeId)),
	array('label'=>'Delete BEmployee', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->EmployeeId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BEmployee', 'url'=>array('admin')),
);
?>

<h1>View BEmployee #<?php echo $model->EmployeeId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'EmployeeId',
		'FirstName',
		'LastName',
		'Status',
	),
)); ?>
