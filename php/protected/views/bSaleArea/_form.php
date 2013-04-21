<?php
/* @var $this BSaleAreaController */
/* @var $model BSaleArea */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bsale-area-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'AreaId'); ?>
		<?php echo $form->textField($model,'AreaId',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'AreaId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'AreaName'); ?>
		<?php echo $form->textField($model,'AreaName',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'AreaName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Province'); ?>
		<?php echo $form->textField($model,'Province',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Province'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'District'); ?>
		<?php echo $form->textField($model,'District',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'District'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SubDistrict'); ?>
		<?php echo $form->textField($model,'SubDistrict',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'SubDistrict'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SupervisorId'); ?>
		<?php echo $form->textField($model,'SupervisorId',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'SupervisorId'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->