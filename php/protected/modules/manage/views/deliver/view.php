<?php

$this->breadcrumbs=array(
    'กำหนดความสัมพันธ์' => array('/manage'),
    'สร้างใบส่งสินค้า' => array('/manage/deliver/'),
    'รายละเอียด'
);

?>

<h3><?php echo 'รายละเอียดใบเบิก ใบส่ง และใบรับ'; ?></h3>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $id1,
    'attributes'=>array(
        array('label'=>'เลขที่ใบเบิก', 'type'=>'raw', 'value'=>$id1),
        array('label'=>'เลขที่ใบส่ง', 'type'=>'raw', 'value'=>$id2),
        array('label'=>'เลขที่ใบรับ', 'type'=>'raw', 'value'=>$id3),
    ),
)); 
?>

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
        'value'=>'Product::model()->formatQty($data,"ReqQty");',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('จำนวนส่ง'),
        'type'=>'raw',
        'value'=>'Product::model()->formatQty($data,"DQty");',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('จำนวนรับ'),
        'type'=>'raw',
        'value'=>'Product::model()->formatQty($data,"RcQty");',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
);

$this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'data-grid',
    'filter'=>$filtersForm,
    'ajaxUpdate'=>false,
	'type'=>'striped bordered condensed',
	'dataProvider' => $dataProvider,
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
