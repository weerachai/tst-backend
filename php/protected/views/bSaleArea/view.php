<?php
/* @var $this BSaleAreaController */
/* @var $model BSaleArea */

$this->breadcrumbs=array(
	'Bsale Areas'=>array('index'),
	$model->AreaId,
);

$this->menu=array(
	array('label'=>'List BSaleArea', 'url'=>array('index')),
	array('label'=>'Create BSaleArea', 'url'=>array('create')),
	array('label'=>'Update BSaleArea', 'url'=>array('update', 'id'=>$model->AreaId)),
	array('label'=>'Delete BSaleArea', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->AreaId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BSaleArea', 'url'=>array('admin')),
);
?>

<h1>View BSaleArea #<?php echo $model->AreaId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'AreaId',
		'AreaName',
		'Province',
		'District',
		'SubDistrict',
		'SupervisorId',
	),
)); ?>
