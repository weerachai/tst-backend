<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'Area',
);

$this->menu = array(
		array('label'=>'เพิ่ม Area', 'url'=>array('create')),
);
?>

<h3>Area</h3>

<?php 
$columns = array(
    array(
        'header'=>CHtml::encode('AreaId'),
        'name'=>'AreaId',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ชื่อพื้นที่ขาย'),
        'name'=>'AreaName',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('SupervisorId'),
        'name'=>'SupervisorId',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ชื่อ Supervisor'),
        'name'=>'Name',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
	array(
		'class' => 'bootstrap.widgets.TbButtonColumn',
		'template'=>'{view} {update} {delete}',
		'buttons'=>array(
			'view' => array(
	    		'label'=>'รายละเอียด',
	        	'url'=>'Yii::app()->createUrl("/master/saleArea/view", array("id"=>$data["id"]))',
		    ),
			'update' => array(
	    		'label'=>'แก้ไขข้อมูล',
	        	'url'=>'Yii::app()->createUrl("/master/saleArea/update", array("id"=>$data["id"]))',
		    ),
			'delete' => array(
	    		'label'=>'ลบข้อมูล',
	        	'url'=>'Yii::app()->createUrl("/master/saleArea/delete", array("id"=>$data["id"]))',
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