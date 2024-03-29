<?php

$this->breadcrumbs=array(
    'กำหนดความสัมพันธ์' => array('/manage'),
    'สร้างใบส่งสินค้า' => array('/manage/deliver/'),
	'รายการใบส่ง' => array('/manage/stockDeliver/admin'),
    'รายละเอียดใบส่ง'
);

$this->menu = array(
	array('label'=>'รายการใบส่ง', 'url' => array('admin')),
);
?>

<h3><?php echo 'รายละเอียดใบส่ง เลขที่: ' . $id; ?></h3>

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
        'header'=>CHtml::encode('จำนวน'),
        'type'=>'raw',
		'value'=>'Product::model()->formatQty($data,"QtyLevel");',
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
