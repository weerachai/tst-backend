<?php

$this->breadcrumbs=array(
    $this->module->id => array('/'.$this->module->id),
	'สร้างใบส่งสินค้า' => array('/'.$this->module->id.'/deliver/'),
	'รายละเอียด IR'
);

$this->menu = array(
	array('label'=>'รายการ IR', 'url' => array('admin')),
);
?>

<h3><?php echo 'รายละเอียด IR เลขที่: ' . $id; ?></h3>

<?php
$columns = array(
    array(
        'header'=>CHtml::encode('เลขที่ใบเบิก'),
        'name'=>'id',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('วันที่เบิก'),
        'name'=>'RequestDate',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('เขตการขาย'),
        'name'=>'SaleName',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
);

$this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'data-grid1',
    'ajaxUpdate'=>false,
	'type'=>'striped bordered condensed',
	'dataProvider' => $dataProvider1,
	'enablePagination' => true,
    'pager' => array(
        'cssFile' => false,
        'header' => false,
        'firstPageLabel' => 'หน้าแรก',
        'prevPageLabel' => 'หน้าก่อน',
        'nextPageLabel' => 'หน้าถัดไป',
        'lastPageLabel' => 'หน้าสุดท้าย',
    ),  
	'columns' => $columns,
)); ?>

<?php 

$columns = array(
    array(
        'header'=>CHtml::encode('รหัสสินค้า'),
        'name'=>'id',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ชื่อสินค้า'),
        'name'=>'ProductName',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('จำนวนเบิก'),
        'type'=>'raw',
        'value'=>'Product::model()->formatQty($data,"QtyLevel");',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('จำนวนอนุมัติ'),
        'type'=>'raw',
        'value'=>'Product::model()->formatQty($data,"QtyOK");',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
        'template'=>'{update}',
        'buttons'=>array(
            'update' => array(
                'label'=>'แก้ไขรายการอนุมัติ',
                'url'=>'Yii::app()->createUrl("/manage/stockIR/update", array("id"=>$data["IRNo"],"productId"=>$data["id"]))',
            ),
        ),
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
);

$this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'data-grid',
    'ajaxUpdate'=>false,
	'type'=>'striped bordered condensed',
	'dataProvider' => $dataProvider2,
	'enablePagination' => true,
    'pager' => array(
        'cssFile' => false,
        'header' => false,
        'firstPageLabel' => 'หน้าแรก',
        'prevPageLabel' => 'หน้าก่อน',
        'nextPageLabel' => 'หน้าถัดไป',
        'lastPageLabel' => 'หน้าสุดท้าย',
    ),  
	'columns' => $columns,
));
?>
