<?php

$this->breadcrumbs=array(
    $this->module->id => array('/'.$this->module->id),
	'สร้างใบส่งสินค้า' => array('/'.$this->module->id.'/deliver/'),
	'สร้างใบเบิก'
);

$this->menu = array(
	array('label'=>'รายการใบเบิก', 'url' => array('admin')),
);
?>

<h3>สร้างใบเบิกสินค้า</h3>

<?php
$this->renderPartial('_form', array(
		'model' => $model,
		'buttons' => 'บันทึก'));
?>