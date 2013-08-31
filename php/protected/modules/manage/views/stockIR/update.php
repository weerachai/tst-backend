<?php

$this->breadcrumbs=array(
    'กำหนดความสัมพันธ์' => array('/manage'),
	'สร้างใบส่งสินค้า' => array('/manage/deliver/'),
    'รายการ IR' => array('/manage/stockIR/admin'),
	'รายละเอียด IR' => array('/manage/stockIR/view&id='.$model->IRNo),
	'แก้ไข'
);

?>

<h3>อนุมัติจำนวนสินค้า: <?php echo $model->product->ProductName; ?></h1>
<div>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'stock-ir-form',
		'type'=>'horizontal',
		'enableAjaxValidation' => true,
	)); ?>

<fieldset>

<?php echo $form->hiddenField($model, 'ProductId'); ?>

<?php echo $form->textFieldRow($model, 'QtyLevel1', array('disabled'=>empty($model->product->PackLevel1),'append'=>' <div id="PackLevel1">'.$model->product->PackLevel1.'</div>')); ?>
<?php echo $form->textFieldRow($model, 'QtyLevel2', array('disabled'=>empty($model->product->PackLevel2),'append'=>' <div id="PackLevel2">'.$model->product->PackLevel2.'</div>')); ?>
<?php echo $form->textFieldRow($model, 'QtyLevel3', array('disabled'=>empty($model->product->PackLevel3),'append'=>' <div id="PackLevel3">'.$model->product->PackLevel3.'</div>')); ?>
<?php echo $form->textFieldRow($model, 'QtyLevel4', array('disabled'=>empty($model->product->PackLevel4),'append'=>' <div id="PackLevel4">'.$model->product->PackLevel4.'</div>')); ?>
<?php echo $form->hiddenField($model, 'PriceLevel1'); ?>
<?php echo $form->hiddenField($model, 'PriceLevel2'); ?>
<?php echo $form->hiddenField($model, 'PriceLevel3'); ?>
<?php echo $form->hiddenField($model, 'PriceLevel4'); ?>
<?php echo $form->hiddenField($model, 'IRNo'); ?>

</fieldset>

<div class="form-actions">
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'แก้ไขรายการ')); ?>
</div>

<?php $this->endWidget(); ?>
</div>