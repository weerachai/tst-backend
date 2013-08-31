<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'Promotion' => array('index'),
	'จัดการ',
);

$this->menu = array(
		array('label'=>'เพิ่มโปรโมชั่น', 'url'=>array('create')),
);
?>

<h3>จัดการโปรโมชั่น</h3>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'page-form',
    'enableAjaxValidation'=>true,
)); ?>
 
<b>เริ่มวันที่ : </b>
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

<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Go'));?>
<?php $this->endWidget(); ?>

<?php
$columns = array(
    array(
        'header'=>CHtml::encode('ชุดโปรโมชั่น'),
        'name'=>'PromotionGroup',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('รหัสโปรโมชั่น'),
        'name'=>'PromotionId',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('เริ่ม'),
        'name'=>'StartDate',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('สิ้นสุด'),
        'name'=>'EndDate',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ประเภท'),
        'name'=>'PromotionType',
        'type'=>'raw',
        'value'=>'Promotion::model()->getPromotionTypeName($data["PromotionType"]);',
        'filter'=>array(
			'sku' => 'รายสินค้า',
			'group' => 'คละสินค้า',
			'bill' => 'ท้ายบิล',
			'accu-all' => 'สะสมทั้งหมด',
			'accu-l1' => 'สะสมกลุ่มใหญ่',
			'accu-l2' => 'สะสมกลุ่มกลาง',
			'accu-l3' => 'สะสมกลุ่มย่อย',
			'accu-sku' => 'สะสมรายสินค้า',
		),
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('รหัสสินค้า / กลุ่มสินค้า'),
        'name'=>'ProductOrGrpId',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ชื่อสินค้า / กลุ่มสินค้า'),
        'name'=>'ProductOrGrpName',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ซื้อขั้นต่ำ'),
        'type'=>'raw',
        'value'=>'Promotion::model()->getMinBuy($data["MinAmount"],$data["MinSku"],$data["MinQty"],$data["Pack"]);',
        'htmlOptions' => array('style'=>'white-space:nowrap;text-align:right;'),
    ),
	array(
		'class' => 'bootstrap.widgets.TbButtonColumn',
		'template'=>'{view}{update}{copy}{delete}',
		'buttons'=>array(
			'view' => array(
	    		'label'=>'รายละเอียด',
	        	'url'=>'Yii::app()->createUrl("/master/promotion/view", array("id"=>$data["id"]))',
		    ),
			'update' => array(
	    		'label'=>'แก้ไขข้อมูล',
	        	'url'=>'Yii::app()->createUrl("/master/promotion/update", array("id"=>$data["id"]))',
		    ),
            'copy' => array(
                'label'=>'copy โปรโมชั่น',
                'imageUrl'=>Yii::app()->request->baseUrl.'/images/copy.png',
                'url'=>'Yii::app()->createUrl("/master/promotion/copy", array("id"=>$data["id"]))',
            ),
			'delete' => array(
	    		'label'=>'ลบข้อมูล',
	        	'url'=>'Yii::app()->createUrl("/master/promotion/delete", array("id"=>$data["id"]))',
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