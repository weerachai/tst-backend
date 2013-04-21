<?php
/* @var $this CDeviceSettingController */
/* @var $model CDeviceSetting */

$this->breadcrumbs=array(
	'Cdevice Settings'=>array('index'),
	$model->SaleId=>array('view','id'=>$model->SaleId),
	'Update',
);

$this->menu=array(
	array('label'=>'List CDeviceSetting', 'url'=>array('index')),
	array('label'=>'Create CDeviceSetting', 'url'=>array('create')),
	array('label'=>'View CDeviceSetting', 'url'=>array('view', 'id'=>$model->SaleId)),
	array('label'=>'Manage CDeviceSetting', 'url'=>array('admin')),
);
?>

<h1>Update CDeviceSetting <?php echo $model->SaleId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>