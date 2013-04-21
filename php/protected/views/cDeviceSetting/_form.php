<?php
/* @var $this CDeviceSettingController */
/* @var $model CDeviceSetting */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cdevice-setting-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'SaleId'); ?>
		<?php echo $form->textField($model,'SaleId',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'SaleId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'PromotionSku'); ?>
		<?php echo $form->textField($model,'PromotionSku',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'PromotionSku'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'PromotionGroup'); ?>
		<?php echo $form->textField($model,'PromotionGroup',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'PromotionGroup'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'PromotionBill'); ?>
		<?php echo $form->textField($model,'PromotionBill',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'PromotionBill'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'PromotionAccu'); ?>
		<?php echo $form->textField($model,'PromotionAccu',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'PromotionAccu'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Vat'); ?>
		<?php echo $form->textField($model,'Vat',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Vat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'OverStock'); ?>
		<?php echo $form->textField($model,'OverStock',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'OverStock'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'DayToClear'); ?>
		<?php echo $form->textField($model,'DayToClear'); ?>
		<?php echo $form->error($model,'DayToClear'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'UpdateAt'); ?>
		<?php echo $form->textField($model,'UpdateAt'); ?>
		<?php echo $form->error($model,'UpdateAt'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->