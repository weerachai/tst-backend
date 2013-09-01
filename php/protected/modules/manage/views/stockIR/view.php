<?php

$this->breadcrumbs=array(
    'กำหนดความสัมพันธ์' => array('/manage'),
	'สร้างใบส่งสินค้า' => array('/manage/deliver/'),
    'รายการ IR' => array('/manage/stockIR/admin'),
	'รายละเอียด IR'
);

$this->menu = array(
	array('label'=>'รายการ IR', 'url' => array('admin')),
);
?>

<h3><?php echo 'รายละเอียด IR เลขที่: ' . $id; ?></h3>

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
    array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
        'template'=>'{deliver}',
        'buttons'=>array(
            'deliver' => array(
                'label'=>'สร้างใบส่ง',
                'imageUrl'=>Yii::app()->request->baseUrl.'/images/deliver.png',
                'url'=>'Yii::app()->createUrl("/manage/stockIR/deliver", array("id"=>$data["id"]))',
                'visible'=>'StockIR::model()->canAddDeliver($data["id"])',
            ),

        ),
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
);

$this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'data-grid1',
    'ajaxUpdate'=>false,
	'type'=>'striped bordered condensed',
	'dataProvider' => $dataProvider1,
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


<div>
<?php $form=$this->beginWidget('CActiveForm', array(
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
        'value'=>'Product::model()->formatQty($data,"ReqQty")',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('จำนวนอนุมัติ'),
        'type'=>'raw',
        'value'=>!empty($model->UpdateAt)?'Product::model()->formatQty($data,"Qty")':'CHtml::dropDownList("Qty[$data[id]][1]",$data["Qty1"],Product::model()->getQtyOptions($data["ReqQty1"],$data["PackLevel1"]),array("style"=>"width:100px;"))'.
            '.CHtml::dropDownList("Qty[$data[id]][2]",$data["Qty2"],Product::model()->getQtyOptions($data["ReqQty2"],$data["PackLevel2"]),array("style"=>"width:100px;"))'.
            '.CHtml::dropDownList("Qty[$data[id]][3]",$data["Qty3"],Product::model()->getQtyOptions($data["ReqQty3"],$data["PackLevel3"]),array("style"=>"width:100px;"))'.
            '.CHtml::dropDownList("Qty[$data[id]][4]",$data["Qty4"],Product::model()->getQtyOptions($data["ReqQty4"],$data["PackLevel4"]),array("style"=>"width:100px;"))',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
);

$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'data-grid',
    'ajaxUpdate'=>false,
    'type'=>'striped bordered condensed',
    'dataProvider' => $dataProvider2,
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
<?php if (empty($model->UpdateAt)) echo CHtml::ajaxSubmitButton('บันทึก',array('stockIR/ajaxupdate','id'=>$id), array('success'=>'reloadGrid')); ?>
<?php $this->endWidget(); ?>
</div>

