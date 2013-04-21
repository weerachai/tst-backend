<?php
/* @var $this SDeviceController */
/* @var $model SDevice */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sdevice-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'DeviceId'); ?>
		<?php echo $form->textField($model,'DeviceId',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'DeviceId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'DeviceKey'); ?>
		<?php echo $form->textField($model,'DeviceKey',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'DeviceKey'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SaleId'); ?>
		<?php echo $form->textField($model,'SaleId',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'SaleId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Username'); ?>
		<?php echo $form->textField($model,'Username',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Password'); ?>
		<?php echo $form->passwordField($model,'Password',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Password'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->