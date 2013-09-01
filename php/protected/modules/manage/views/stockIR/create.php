<?php

$this->breadcrumbs=array(
    'กำหนดความสัมพันธ์' => array('/manage'),
    'สร้างใบส่งสินค้า' => array('/manage/deliver/'),
    'รายการ IR' => array('/manage/stockIR/admin'),
	'สร้าง IR'
);

$this->menu = array(
	array('label'=>'รายการ IR', 'url' => array('admin')),
);
?>

<h3>สร้าง IR</h3>

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
<b> เขตการขาย : </b>
<?php echo CHtml::dropDownList('saleId', $saleId, SaleUnit::model()->getAssigendOptions(), array('empty'=>'(ทั้งหมด)')); ?>

<b> สถานะ : </b>
<?php echo CHtml::dropDownList('flag', $flag, array('ต้นทริป'=>'ต้นทริป','ระหว่างทริป'=>'ระหว่างทริป'), array('empty'=>'(ทั้งหมด)')); ?>

<?php echo CHtml::submitButton('ค้นหา'); ?>
<?php $this->endWidget(); ?>

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

<?php if ($ok) { ?>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'create-form',
)); ?>
<?php echo CHtml::hiddenField('from_date',$from_date); ?>
<?php echo CHtml::hiddenField('to_date',$to_date); ?>
<?php echo CHtml::hiddenField('saleId',$saleId); ?>
<?php echo CHtml::hiddenField('flag',$flag); ?>
<?php echo CHtml::hiddenField('create','1'); ?>
<?php echo CHtml::submitButton('สร้าง IR'); ?>
<?php $this->endWidget(); ?>
<?php } ?>