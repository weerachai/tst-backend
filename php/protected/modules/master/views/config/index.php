<?php
$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'Settings'
);

$this->menu=array(
	array('label'=>'แก้ไข', 'url'=>array('update')),
);
?>
<h3>ค่า Settings</h3>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
    'attributes'=>array(
	    array('name'=>'DayToClear', 'type'=>'raw', 'value'=>$model->DayToClear.' วัน'),
	    array('name'=>'Vat', 'type'=>'raw', 'value'=>($model->Vat == 'bill' ? 'ท้ายบิล' : 'รายสินค้า')),
	    array('name'=>'OverStock', 'type'=>'raw', 'value'=>($model->OverStock == 'Y' ? 'ได้' : 'ไม่ได้')),
 	    array('name'=>'ExchangeDiff', 'type'=>'raw', 'value'=>$model->ExchangeDiff.' บาท'),
 	    array('name'=>'ExchangePaymentMethod', 'type'=>'raw', 'value'=>($model->ExchangePaymentMethod == 'bill' ? 'ส่ง Bill Collection' : 'เก็บเงินสด')),
    ),
)); 
?>
