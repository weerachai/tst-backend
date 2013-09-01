<?php

$this->breadcrumbs=array(
    'กำหนดความสัมพันธ์' => array('/manage'),
    'สร้างใบส่งสินค้า' => array('/manage/deliver/'),
	'รายการใบส่ง',
);

?>

<h3>รายการใบส่ง</h3>

<p>

<?php
$columns = array(
    array(
        'header'=>CHtml::encode('เลขที่ใบเบิก'),
        'name'=>'RequestNo',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('เลขที่ใบส่ง'),
        'name'=>'id',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('วันที่ส่ง'),
        'name'=>'DeliverDate',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
   	array(
		'class' => 'bootstrap.widgets.TbButtonColumn',
		'template'=>'{view} {update} {delete}',
		'buttons'=>array(
            'view' => array(
                'label'=>'รายละเอียดใบส่ง',
                'url'=>'Yii::app()->createUrl("/manage/stockDeliver/view", array("id"=>$data["id"]))',
            ),
            'update' => array(
                'label'=>'แก้ไข',
                'url'=>'Yii::app()->createUrl("/manage/stockDeliver/update", array("id"=>$data["id"]))',
                'visible'=>'$data["Status"]=="อยู่ระหว่างบันทึก"',
		    ),
            'delete' => array(
                'label'=>'ยกเลิก',
                'url'=>'Yii::app()->createUrl("/manage/stockDeliver/delete", array("id"=>$data["id"]))',
                'visible'=>'$data["Status"]!="ส่งข้อมูลแล้ว"',
		    ),
		),
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
