<?php
/* @var $this RunningController */

$this->breadcrumbs=array(
    'กำหนดความสัมพันธ์' => array('/manage'),
	'Running No',
);
?>

<h3>ข้อมูล Running No</h3>

<p><h4 style="color:green">
	<?php echo $message; ?>
</h4></p>

<?php 
$columns = array(
    array(
        'header'=>CHtml::encode('รหัสอุปกรณ์'),
        'name'=>'DeviceId',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ชื่อพนักงานขาย'),
        'name'=>'Name',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('รหัส'),
        'name'=>'ControlId',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('เอกสาร'),
        'name'=>'ControlName',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('Prefix'),
        'name'=>'Prefix',
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
        'header'=>CHtml::encode('Running'),
        'name'=>'No',
        'value'=>'sprintf("%04d", $data["No"]);',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
	array(
		'class' => 'bootstrap.widgets.TbButtonColumn',
		'template'=>'{update}',
		'buttons'=>array(
			'update' => array(
	        	'url'=>'Yii::app()->createUrl("/manage/running/update", array("saleId"=>$data["SaleId"],"controlId"=>$data["ControlId"]))',
		    ),
		),
		'htmlOptions' => array('style'=>'white-space:nowrap'),
 	),
);

$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'id'=>'running-grid',
    'filter'=>$filtersForm,
    'ajaxUpdate'=>false,
	'type' => 'striped bordered',
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
//	'template' => "{items}",
	'columns' => $columns,
	/*
	'bulkActions' => array(
	'actionButtons' => array(
		array(
			'id' => 'delete',
			'buttonType' => 'button',
			'type' => 'primary',
			'size' => 'small',
			'label' => 'Testing Primary Bulk Actions',
			'click' => 'js:function(values){console.log(values);}'
			)
		),
		// if grid doesn't have a checkbox column type, it will attach
		// one and this configuration will be part of it
		'checkBoxColumnConfig' => array(
		    'name' => 'id'
		),
	),
	'extendedSummary' => array(
		'title' => 'จำนวนร้านค้า',
		'columns' => array(
			'Num' => array('label'=>'จำนวนร้าน', 'class'=>'TbSumOperation')
		)
	),
	'extendedSummaryOptions' => array(
		'class' => 'well pull-right',
		'style' => 'width:300px'
	),
	*/
));

?>
