<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'Area' => array('index'),
	'เพิ่มข้อมูล',
);

$this->menu = array(
	array('label'=>'จัดการ Area', 'url'=>array('index')),
);
?>

<h3>เพิ่มข้อมูล Area</h3>

<?php
$this->renderPartial('_form', array(
		'model' => $model,
		'buttons' => 'create'));
?>