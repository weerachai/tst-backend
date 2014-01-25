<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'พนักงาน' => array('index'),
	GxHtml::valueEx($model),
);

$this->menu=array(
	array('label'=>'จัดการพนักงาน', 'url'=>array('index')),
	array('label'=>'แก้ไขพนักงาน', 'url'=>array('update', 'id' => $model->EmployeeId)),
	array('label'=>'ลบพนักงาน', 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->EmployeeId), 'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h3><?php echo 'รายละเอียดพนักงาน ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h3>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
'EmployeeId',
'FirstName',
'LastName',
	),
)); ?>

