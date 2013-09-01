<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'Promotion' => array('index'),
	$model->PromotionId,
);

$this->menu=array(
	array('label'=>'จัดการโปรโมชั่น', 'url'=>array('index')),
    array('label'=>'เพิ่มโปรโมชั่นรายสินค้า', 'url'=>array('create','type'=>'sku')),
    array('label'=>'เพิ่มโปรโมชั่นกลุ่มสินค้า', 'url'=>array('create','type'=>'group')),
    array('label'=>'เพิ่มโปรโมชั่นท้ายบิล', 'url'=>array('create','type'=>'bill')),
    array('label'=>'เพิ่มโปรโมชั่นสะสม', 'url'=>array('create','type'=>'accu')),
	array('label'=>'แก้ไขโปรโมชั่น', 'url'=>array('update', 'id' => $model->PromotionId)),
	array('label'=>'ลบโปรโมชั่น', 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->PromotionId), 'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h3><?php echo 'รายละเอียดโปรโมชั่น ' . GxHtml::encode($model->PromotionId); ?></h3>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
    'attributes'=>array(
	    array('name'=>'PromotionGroup', 'label'=>'ชุดโปรโมชั่น'),
	    array('name'=>'PromotionId', 'label'=>'รหัสโปรโมชั่น'),
	    array('name'=>'StartDate', 'label'=>'เริ่มต้น'),
	    array('name'=>'EndDate', 'label'=>'สิ้นสุด'),
	    array('label'=>'ประเภท', 'type'=>'raw',
            'value'=>Promotion::model()->getPromotionTypeName($model->PromotionType)),
	    array('name'=>'ProductOrGrpId', 'label'=>'รหัสสินค้า/กลุ่มสินค้า'),
	    array('label'=>'ชื่อสินค้า/กลุ่มสินค้า', 'type'=>'raw',
            'value'=>Promotion::model()->getProductOrGrpName($model->PromotionType, $model->ProductOrGrpId)),
	    array('label'=>'ซื้อขั้นต่ำ', 'type'=>'raw',
            'value'=>Promotion::model()->getMinBuy($model->MinAmount, $model->MinSku, $model->MinQty, $model->Pack)),
	    array('label'=>'ส่วนลด', 'type'=>'raw',
            'value'=>Promotion::model()->getDiscount($model)),
	    array('label'=>'แถม', 'type'=>'raw',
            'value'=>Promotion::model()->getFree($model)),
	    array('label'=>'สูตร', 'type'=>'raw',
            'value'=>Promotion::model()->getFormulaName($model->Formula)),
    ))
); 
?>