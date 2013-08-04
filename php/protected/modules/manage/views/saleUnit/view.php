<?php

$this->breadcrumbs = array(
    $this->module->id => array('/'.$this->module->id),
	'หน่วยขาย' => array('index'),
	GxHtml::valueEx($model),
);
?>

<h3>รายละเอียด <?php echo GxHtml::encode(GxHtml::valueEx($model)); ?></h3>

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

