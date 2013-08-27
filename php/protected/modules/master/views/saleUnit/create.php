<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'หน่วยขาย และ Device' => array('index'),
	'เพิ่มข้อมูล',
);

$this->menu = array(
	array('label'=>'จัดการหน่วยขาย และ Device', 'url'=>array('index')),
);
?>

<h3>เพิ่มข้อมูลหน่วยขาย และ Device</h3>

<?php
$this->renderPartial('_form', array(
		'model' => $model,
		'buttons' => 'create'));
?>