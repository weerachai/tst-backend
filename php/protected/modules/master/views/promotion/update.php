<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'Promotion' => array('index'),
	$model->PromotionId => array('view', 'id' => GxActiveRecord::extractPkValue($model, true)),
	'แก้ไข',
);

$this->menu=array(
	array('label'=>'จัดการโปรโมชั่น', 'url'=>array('index')),
	array('label'=>'เพิ่มโปรโมชั่น', 'url'=>array('create')),
	array('label'=>'รายละเอียดโปรโมชั่น', 'url'=>array('view', 'id' => GxActiveRecord::extractPkValue($model, true))),
);

?>

<h3><?php echo 'แก้ไขโปรโมชั่น ' . GxHtml::encode($model->PromotionId); ?></h3>

<?php
$this->renderPartial('_form', array(
		'model' => $model));
?>