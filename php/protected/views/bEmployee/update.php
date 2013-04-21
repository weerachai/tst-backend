<?php
/* @var $this BEmployeeController */
/* @var $model BEmployee */

$this->breadcrumbs=array(
	'Bemployees'=>array('index'),
	$model->EmployeeId=>array('view','id'=>$model->EmployeeId),
	'Update',
);

$this->menu=array(
	array('label'=>'List BEmployee', 'url'=>array('index')),
	array('label'=>'Create BEmployee', 'url'=>array('create')),
	array('label'=>'View BEmployee', 'url'=>array('view', 'id'=>$model->EmployeeId)),
	array('label'=>'Manage BEmployee', 'url'=>array('admin')),
);
?>

<h1>Update BEmployee <?php echo $model->EmployeeId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>