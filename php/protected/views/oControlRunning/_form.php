<?php
/* @var $this OControlRunningController */
/* @var $model OControlRunning */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ocontrol-running-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'ControlId'); ?>
		<?php echo $form->textField($model,'ControlId',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'ControlId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ControlName'); ?>
		<?php echo $form->textField($model,'ControlName',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'ControlName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Prefix'); ?>
		<?php echo $form->textField($model,'Prefix',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Prefix'); ?>
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