<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'Control Running',
);

?>

<h3>Control Running</h3>

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
        'header'=>CHtml::encode('รหัส'),
        'name'=>'ControlId',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ข้อมูล'),
        'name'=>'ControlName',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('Prefix'),
        'name'=>'Prefix',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('รหัสอุปกรณ์'),
        'name'=>'DeviceId',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('Year'),
        'name'=>'Year',
        'value'=>'sprintf("%02d", $data["Year"]);',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('Month'),
        'name'=>'Month',
        'value'=>'sprintf("%02d", $data["Month"]);',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('No'),
        'name'=>'No',
        'value'=>'sprintf("%04d", $data["No"]);',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
	array(
		'class' => 'bootstrap.widgets.TbButtonColumn',
		'template'=>'{update}',
		'buttons'=>array(
			'update' => array(
	    		'label'=>'แก้ไขข้อมูล',
	        	'url'=>'Yii::app()->createUrl("/master/controlNo/update", array("SaleId"=>$data["SaleId"],"ControlId"=>$data["ControlId"]))',
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