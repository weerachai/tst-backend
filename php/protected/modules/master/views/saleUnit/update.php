<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'หน่วยขาย และ Device' => array('index'),
	GxHtml::valueEx($model) => array('view', 'id' => GxActiveRecord::extractPkValue($model, true)),
	'แก้ไข',
);

$this->menu=array(
	array('label'=>'จัดการหน่วยขาย และ Device', 'url'=>array('index')),
	array('label'=>'รายละเอียดหน่วยขาย และ Device', 'url'=>array('view', 'id' => GxActiveRecord::extractPkValue($model, true))),
);
?>

<h3><?php echo 'แก้ไข' . GxHtml::encode(GxHtml::valueEx($model)); ?></h3>

<?php
$this->renderPartial('_form', array(
		'model' => $model));
?>