<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'หน่วยขาย และ Device' => array('index'),
	GxHtml::valueEx($model),
);

$this->menu=array(
	array('label'=>'จัดการหน่วยขาย และ Device', 'url'=>array('index')),
	array('label'=>'แก้ไขหน่วยขาย และ Device', 'url'=>array('update', 'id' => $model->SaleId)),
	array('label'=>'ลบหน่วยขาย และ Device', 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->SaleId), 'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h3><?php echo 'รายละเอียด' . GxHtml::encode(GxHtml::valueEx($model)); ?></h3>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
    'attributes'=>array(
	    array('name'=>'SaleId', 'label'=>'รหัสหน่วยขาย'),
	    array('name'=>'SaleName', 'label'=>'ชื่อหน่วยขาย'),
	    array('name'=>'SaleType', 'label'=>'ประเภทการขาย'),
	    array('name'=>'device.DeviceId', 'label'=>'รหัสอุปกรณ์'),
	    array('name'=>'device.DeviceKey', 'label'=>'เลขอุปกรณ์'),
	    array('name'=>'device.Username', 'label'=>'รหัสผู้ใช้'),
    ),
)); ?>

