<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'พนักงาน' => array('index'),
	GxHtml::valueEx($model) => array('view', 'id' => GxActiveRecord::extractPkValue($model, true)),
	'แก้ไข',
);

$this->menu=array(
	array('label'=>'จัดการพนักงาน', 'url'=>array('index')),
	array('label'=>'เพิ่มพนักงาน', 'url'=>array('create')),
	array('label'=>'รายละเอียดพนักงาน', 'url'=>array('view', 'id' => GxActiveRecord::extractPkValue($model, true))),
);
?>

<h3><?php echo 'แก้ไขพนักงาน ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h3>

<?php
$this->renderPartial('_form', array(
		'model' => $model));
?>