<?php

$this->breadcrumbs=array(
    'กำหนดความสัมพันธ์' => array('/manage'),
	'กำหนดโปรโมชั่น',
);
?>

<h3>ข้อมูลโปรโมชั่น</h3>

<?php 
$columns = array(
      array(
      'name'=>'SaleId',
      'header'=>'รหัสหน่วยขาย',
      'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      array(
      'name'=>'SaleName',
      'header'=>'ชื่อหน่วยขาย',
      'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      array(
      'name'=>'PromotionSku',
      'header'=>'ชุดโปรโมชั่นรายสินค้า',
      'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      array(
      'name'=>'PromotionGroup',
      'header'=>'ชุดโปรโมชั่นกลุ่ม',
      'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      array(
      'name'=>'PromotionBill',
      'header'=>'ชุดโปรโมชั่นท้ายบิล',
      'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      array(
      'name'=>'PromotionAccu',
      'header'=>'ชุดโปรโมชั่นสะสม',
      'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template'=>'{delete}',
            'buttons'=>array(
                  'delete' => array(
                  'label'=>'ยกเลิกโปรโมชั่น',
	        	  'url'=>'Yii::app()->createUrl("/manage/promotion/delete", array("id"=>$data["SaleId"]))',
                ),
            ),
            'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
);

$this->widget('bootstrap.widgets.TbExtendedGridView', array(
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
));

?>

<h3>กำหนดเขตการขายของร้านค้า</h3>
<div>
<?php $form = $this->beginWidget('CActiveForm'); ?>

<div class="row">
<?php echo CHtml::label('หน่วยขาย: ',  'SaleId'); ?>
<?php echo CHtml::dropDownList('SaleId',  null, SaleUnit::model()->getNoPromotionOptions()); ?>

<?php echo CHtml::label('โปรโมชั่นรายสินค้า: ',  'PromotionSku'); ?>
<?php echo CHtml::dropDownList('PromotionSku',  null, Promotion::model()->getPromotionOptions('sku'), array('empty' => '-')); ?>

<?php echo CHtml::label('โปรโมชั่นรายกลุ่ม: ',  'PromotionGroup'); ?>
<?php echo CHtml::dropDownList('PromotionGroup',  null, Promotion::model()->getPromotionOptions('group'), array('empty' => '-')); ?>

<?php echo CHtml::label('โปรโมชั่นรายท้ายบิล: ',  'PromotionBill'); ?>
<?php echo CHtml::dropDownList('PromotionBill',  null, Promotion::model()->getPromotionOptions('bill'), array('empty' => '-')); ?>

<?php echo CHtml::label('โปรโมชั่นรายสะสม: ',  'PromotionAccu'); ?>
<?php echo CHtml::dropDownList('PromotionAccu',  null, Promotion::model()->getPromotionOptions('accu'), array('empty' => '-')); ?>

<?php echo GxHtml::submitButton(Yii::t('app', 'กำหนดโปรโมชั่น')); ?>
</div><!-- row -->
<?php $this->endWidget(); ?>
</div>