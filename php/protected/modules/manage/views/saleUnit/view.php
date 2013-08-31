<?php
$this->breadcrumbs=array(
  'กำหนดความสัมพันธ์' => array('/manage'),
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

