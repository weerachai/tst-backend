<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'Promotion' => array('index'),
	'เพิ่มข้อมูล',
);

$this->menu = array(
	array('label'=>'จัดการโปรโมชั่น', 'url'=>array('index')),
);

?>

<h3>เพิ่มข้อมูลโปรโมชั่น</h3>

<?php
$this->renderPartial('_form', array(
		'model' => $model,
		'buttons' => 'create'));
?>