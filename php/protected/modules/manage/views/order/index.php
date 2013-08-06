<?php

$this->breadcrumbs=array(
    $this->module->id => array('/'.$this->module->id),
	'ใบสั่งซื้อ',
);

?>

<h3>เตรียมสถานะใบสั่งซื้อ</h3>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'page-form',
    'enableAjaxValidation'=>true,
)); ?>
 
<b>From :</b>
<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'from_date',  // name of post parameter
    'value'=>isset(Yii::app()->request->cookies['from_date']) ? Yii::app()->request->cookies['from_date'] : '',  // value comes from cookie after submittion
     'options'=>array(
        'showAnim'=>'fold',
        'dateFormat'=>'yy-mm-dd',
    ),
    'htmlOptions'=>array(
        'style'=>'height:20px;'
    ),
));
?>
<b>To :</b>
<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'to_date',
    'value'=>isset(Yii::app()->request->cookies['to_date']) ? Yii::app()->request->cookies['to_date'] : '',
     'options'=>array(
        'showAnim'=>'fold',
        'dateFormat'=>'yy-mm-dd',
 
    ),
    'htmlOptions'=>array(
        'style'=>'height:20px;'
    ),
));
?>
<?php echo CHtml::submitButton('Go'); ?>
<?php $this->endWidget(); ?>

<?php
$columns = array(
    array(
        'header'=>CHtml::encode('เลขที่ออเดอร์'),
        'name'=>'id',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('วันที่ออเดอร์'),
        'name'=>'OrderDate',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('เลชที่อินวอยซ์'),
        'name'=>'InvoiceNo',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('พนักงานขาย'),
        'name'=>'Name',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('หน่วยขาย'),
        'name'=>'SaleName',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('สถานะออเดอร์'),
        'name'=>'OrderStatus',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('สถานะอินวอยซ์'),
        'name'=>'InvoiceStatus',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
);

$this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'product-order-grid',
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