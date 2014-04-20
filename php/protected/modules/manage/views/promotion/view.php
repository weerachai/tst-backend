<?php

$this->breadcrumbs = array(
    'กำหนดความสัมพันธ์' => array('/manage'),
	'กำหนดโปรโมชั่น' => array('index'),
	'รายชื่อ',
);
?>

<h3>รายชื่อร้านค้า</h3>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(               
            'label'=>'รหัสหน่วยขาย',
            'type'=>'raw',
            'value'=>CHtml::encode($model->SaleId),
        ),
        array(               
            'label'=>'ชื่อหน่วยขาย',
            'type'=>'raw',
            'value'=>CHtml::encode($model->saleUnit->SaleName),
        ),
        array(               
            'label'=>'จังหวัด',
            'type'=>'raw',
            'value'=>CHtml::encode($model->Province),
        ),
        array(               
            'label'=>'อำเภอ',
            'type'=>'raw',
            'value'=>CHtml::encode($model->District),
        ),
        array(               
            'label'=>'ตำบล',
            'type'=>'raw',
            'value'=>CHtml::encode($model->SubDistrict),
        ),
        array(               
            'label'=>'ชุดโปรโมชั่นรายสินค้า',
            'type'=>'raw',
            'value'=>CHtml::encode($model->PromotionSku),
        ),
        array(               
            'label'=>'ชุดโปรโมชั่นกลุ่ม',
            'type'=>'raw',
            'value'=>CHtml::encode($model->PromotionGroup),
        ),
        array(               
            'label'=>'ชุดโปรโมชั่นท้ายบิล',
            'type'=>'raw',
            'value'=>CHtml::encode($model->PromotionBill),
        ),
        array(               
            'label'=>'ชุดโปรโมชั่นสะสม',
            'type'=>'raw',
            'value'=>CHtml::encode($model->PromotionAccu),
        ),
    ),
)); ?>

<?php 
$columns = array(
    array(
        'header'=>CHtml::encode('รหัสร้านค้า'),
        'name'=>'CustomerId',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ชื่อร้านค้า'),
        'name'=>'CustomerName',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
);

$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'id'=>'customer-grid',
	'type' => 'striped',
	'dataProvider' => $dataProvider,
	'template' => "{items}",
	'columns' => $columns,
));

 ?>
