<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);
?>

<h1>รายละเอียด <?php echo GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
'area.AreaId',
'area.AreaName',
'area.Province',
'area.District',
'area.SubDistrict',
'area.supervisor',
'SaleId',
'SaleName',
'SaleType',
'EmployeeId',
'AreaId',
'device.DeviceId',
'device.DeviceKey',
'device.Username',
'employee.EmployeeId',
'employee.FirstName',
'employee.LastName',
	),
)); ?>

