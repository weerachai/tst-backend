<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'Promotion' => array('index'),
	$model->PromotionId => array('view', 'id' => GxActiveRecord::extractPkValue($model, true)),
	'แก้ไข',
);

$this->menu=array(
	array('label'=>'จัดการโปรโมชั่น', 'url'=>array('index')),
    array('label'=>'เพิ่มโปรโมชั่นรายสินค้า', 'url'=>array('create','type'=>'sku')),
    array('label'=>'เพิ่มโปรโมชั่นกลุ่มสินค้า', 'url'=>array('create','type'=>'group')),
    array('label'=>'เพิ่มโปรโมชั่นท้ายบิล', 'url'=>array('create','type'=>'bill')),
    array('label'=>'เพิ่มโปรโมชั่นสะสม', 'url'=>array('create','type'=>'accu')),
	array('label'=>'รายละเอียดโปรโมชั่น', 'url'=>array('view', 'id' => GxActiveRecord::extractPkValue($model, true))),
);

?>

<h3><?php
echo 'แก้ไขโปรโมชั่น';
if ($type == 'sku')
	echo 'รายสินค้า';
elseif ($type == 'group')
	echo 'กลุ่มสินค้า';
elseif ($type == 'bill')
	echo 'ท้ายบิล';
elseif ($type == 'accu')
	echo 'สะสม';
echo '  ' . GxHtml::encode($model->PromotionId);
?>
</h3>
<?php
$this->renderPartial('_form', array(
		'model' => $model,
		'type' => $type));
?>