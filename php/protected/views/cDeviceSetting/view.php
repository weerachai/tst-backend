<?php
/* @var $this CDeviceSettingController */
/* @var $model CDeviceSetting */

$this->breadcrumbs=array(
	'Cdevice Settings'=>array('index'),
	$model->SaleId,
);

$this->menu=array(
	array('label'=>'List CDeviceSetting', 'url'=>array('index')),
	array('label'=>'Create CDeviceSetting', 'url'=>array('create')),
	array('label'=>'Update CDeviceSetting', 'url'=>array('update', 'id'=>$model->SaleId)),
	array('label'=>'Delete CDeviceSetting', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->SaleId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CDeviceSetting', 'url'=>array('admin')),
);
?>

<h1>View CDeviceSetting #<?php echo $model->SaleId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'SaleId',
		'PromotionSku',
		'PromotionGroup',
		'PromotionBill',
		'PromotionAccu',
		'Vat',
		'OverStock',
		'DayToClear',
		'UpdateAt',
	),
)); ?>
