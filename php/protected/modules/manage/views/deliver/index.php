<?php

$this->breadcrumbs=array(
    'กำหนดความสัมพันธ์' => array('/manage'),
	'สร้างใบส่งสินค้า',
);

$this->menu = array(
	array('label'=>Yii::t('app', 'รายการใบเบิก'), 'url' => array('StockRequest/admin')),
	array('label'=>Yii::t('app', 'รายการ IR'), 'url' => array('StockIR/admin')),
	array('label'=>Yii::t('app', 'รายการใบส่ง'), 'url' => array('StockDeliver/admin')),
);

?>

<h3>รายการใบเบิก ใบส่งสินค้า และใบรับสินค้า</h3>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'page-form',
    'enableAjaxValidation'=>true,
)); ?>
 
<b>วันที่เบิก เริ่มวันที่ : </b>
<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'from_date',  // name of post parameter
    'value'=>$from_date,  // value comes from cookie after submittion
     'options'=>array(
        'showAnim'=>'fold',
        'dateFormat'=>'yy-mm-dd',
    ),
    'htmlOptions'=>array(
        'style'=>'height:20px;'
    ),
));
?>
<b> ถึงวันที่ : </b>
<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'to_date',
    'value'=>$to_date,
     'options'=>array(
        'showAnim'=>'fold',
        'dateFormat'=>'yy-mm-dd',
 
    ),
    'htmlOptions'=>array(
        'style'=>'height:20px;'
    ),
));
?>
<br />
<b> สถานะ : </b>
<?php echo CHtml::dropDownList('status', $status, array('0'=>'(ทั้งหมด)','1'=>'ยังไม่มีใบส่ง','2'=>'ส่งใบส่งแล้วแต่ยังไม่ได้ใบรับ')); ?>

<?php echo CHtml::submitButton('Go'); ?>
<?php $this->endWidget(); ?>

<?php
$columns = array(
    array(
        'header'=>CHtml::encode('เลขที่ใบเบิก'),
        'name'=>'id',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ประเภท'),
        'name'=>'RequestType',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('Flag'),
        'name'=>'RequestFlag',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('วันที่เบิก'),
        'name'=>'RequestDate',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('เลขที่ใบส่ง'),
        'name'=>'DeliverNo',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('สถานะ'),
        'name'=>'Status',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('วันที่ส่ง'),
        'name'=>'DeliverDate',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('เลขที่ใบรับ'),
        'name'=>'ReceiveNo',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('วันที่รับ'),
        'name'=>'ReceiveDate',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
   	array(
		'class' => 'bootstrap.widgets.TbButtonColumn',
		'template'=>'{view}',
		'buttons'=>array(
			'view' => array(
	    		'label'=>'แสดงรายละเอียด',
	        	'url'=>'Yii::app()->createUrl("/manage/deliver/view", array("id1"=>$data["id"],"id2"=>$data["DeliverNo"],"id3"=>$data["ReceiveNo"]))',
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
)); ?>