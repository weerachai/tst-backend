<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'หน่วยขาย และ Device',
);

$this->menu = array(
		array('label'=>'เพิ่มหน่วยขาย และ Device', 'url'=>array('create')),
	);

?>

<h3>หน่วยขาย และ Device</h3>

<?php 
$columns = array(
    array(
        'header'=>CHtml::encode('รหัสหน่วยขาย'),
        'name'=>'SaleId',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ชื่อหน่วยขาย'),
        'name'=>'SaleName',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('รหัสอุปกรณ์'),
        'name'=>'DeviceId',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('รหัสผู้ใช้'),
        'name'=>'Username',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ประเภทการขาย'),
        'name'=>'SaleType',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
	array(
		'class' => 'bootstrap.widgets.TbButtonColumn',
		'template'=>'{view} {update} {delete}',
		'buttons'=>array(
			'view' => array(
	    		'label'=>'รายละเอียด',
	        	'url'=>'Yii::app()->createUrl("/master/saleUnit/view", array("id"=>$data["id"]))',
		    ),
			'update' => array(
	    		'label'=>'แก้ไขข้อมูล',
	        	'url'=>'Yii::app()->createUrl("/master/saleUnit/update", array("id"=>$data["id"]))',
		    ),
			'delete' => array(
	    		'label'=>'ลบข้อมูล',
	        	'url'=>'Yii::app()->createUrl("/master/saleUnit/delete", array("id"=>$data["id"]))',
		    ),
		),
		'htmlOptions' => array('style'=>'white-space:nowrap'),
 	),
);

$this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'data-grid',
	'dataProvider' => $dataProvider,
    'filter'=>$filtersForm,
    'ajaxUpdate'=>true,
	'type'=>'striped bordered condensed',
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