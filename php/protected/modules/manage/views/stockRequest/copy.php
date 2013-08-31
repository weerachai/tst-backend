<?php

$this->breadcrumbs=array(
    'กำหนดความสัมพันธ์' => array('/manage'),
	'สร้างใบส่งสินค้า' => array('/manage/deliver/'),
    'รายการใบเบิก' => array('/manage/stockRequest/admin'),
   	'copy ใบเบิก'
);

$this->menu = array(
	array('label'=>'รายการใบเบิก', 'url' => array('admin')),
);
?>

<h3><?php echo 'copy ใบเบิกสินค้า เลขที่: ' . $id; ?></h3>

<?php
$this->renderPartial('_form', array(
		'model' => $model,
		'buttons' => 'บันทึก'));
?>