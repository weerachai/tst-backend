<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'Area' => array('index'),
	GxHtml::valueEx($model) => array('view', 'id' => GxActiveRecord::extractPkValue($model, true)),
	'แก้ไข',
);

$this->menu=array(
	array('label'=>'จัดการ Area', 'url'=>array('index')),
	array('label'=>'เพิ่ม Area', 'url'=>array('create')),
	array('label'=>'รายละเอียด Area', 'url'=>array('view', 'id' => GxActiveRecord::extractPkValue($model, true))),
);
?>

<h3><?php echo 'แก้ไข' . GxHtml::encode(GxHtml::valueEx($model)); ?></h3>

<?php
$this->renderPartial('_form', array(
		'model' => $model));
?>