<?php

$this->breadcrumbs=array(
    'กำหนดความสัมพันธ์' => array('/manage'),
    'สร้างใบส่งสินค้า' => array('/manage/deliver/'),
	'รายการใบส่ง' => array('/manage/stockDeliver/admin'),
	'แก้ไข'
);

?>

<h3>แก้ไขรายละเอียดใบส่งสินค้าเลขที่: <?php echo $id; ?></h1>

<div>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'enableAjaxValidation'=>true,
)); ?>
 
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
        'value'=>'CHtml::dropDownList("Qty[$data[id]][1]",$data["Qty1"],Product::model()->getQtyOptions(StockIR::model()->getMaxQty($data["id"],$data["DeliverNo"],$data["ReqQty1"],1),$data["PackLevel1"]),array("style"=>"width:100px;"))'.
       	 	'.CHtml::dropDownList("Qty[$data[id]][2]",$data["Qty2"],Product::model()->getQtyOptions(StockIR::model()->getMaxQty($data["id"],$data["DeliverNo"],$data["ReqQty2"],2),$data["PackLevel2"]),array("style"=>"width:100px;"))'.
       	 	'.CHtml::dropDownList("Qty[$data[id]][3]",$data["Qty3"],Product::model()->getQtyOptions(StockIR::model()->getMaxQty($data["id"],$data["DeliverNo"],$data["ReqQty3"],3),$data["PackLevel3"]),array("style"=>"width:100px;"))'.
       	 	'.CHtml::dropDownList("Qty[$data[id]][4]",$data["Qty4"],Product::model()->getQtyOptions(StockIR::model()->getMaxQty($data["id"],$data["DeliverNo"],$data["ReqQty4"],4),$data["PackLevel4"]),array("style"=>"width:100px;"))',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
);

$this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'data-grid',
    'ajaxUpdate'=>false,
	'type'=>'striped bordered condensed',
	'dataProvider' => $dataProvider,
	'enablePagination' => false,
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
<script>
function reloadGrid(data) {
	alert("บันทึกข้อมูลแล้ว");
    $.fn.yiiGridView.update('data-grid');
}
</script>
<?php echo GxHtml::ajaxSubmitButton('บันทึก',array('stockDeliver/ajaxupdate','id'=>$id), array('success'=>'reloadGrid')); ?>
<?php $this->endWidget(); ?>
</div>

<div>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>
<?php echo GxHtml::submitButton(Yii::t('app', 'ยืนยัน'), array('confirm'=>'กรุณายืนยัน')); ?>
<?php $this->endWidget(); ?>
</div>