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

<h3><?php
echo 'เพิ่มข้อมูลโปรโมชั่น';
if ($type == 'sku')
	echo 'รายสินค้า';
elseif ($type == 'group')
	echo 'กลุ่มสินค้า';
elseif ($type == 'bill')
	echo 'ท้ายบิล';
elseif ($type == 'accu')
	echo 'สะสม';
?>
</h3>

<?php
$this->renderPartial('_form', array(
		'model' => $model,
		'type' => $type));
?>