<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'พนักงาน' => array('index'),
	'เพิ่มข้อมูล',
);

$this->menu = array(
	array('label'=>'จัดการพนักงาน', 'url'=>array('index')),
);
?>

<h3>เพิ่มข้อมูลพนักงาน</h3>

<?php
$this->renderPartial('_form', array(
		'model' => $model,
		'buttons' => 'create'));
?>