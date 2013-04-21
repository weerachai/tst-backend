<?php
/* @var $this BSaleUnitController */
/* @var $model BSaleUnit */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bsale-unit-form',
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
		<?php echo $form->labelEx($model,'SaleName'); ?>
		<?php echo $form->textField($model,'SaleName',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'SaleName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SaleType'); ?>
		<?php echo $form->textField($model,'SaleType',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'SaleType'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'EmployeeId'); ?>
		<?php echo $form->textField($model,'EmployeeId',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'EmployeeId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'AreaId'); ?>
		<?php echo $form->textField($model,'AreaId',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'AreaId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Active'); ?>
		<?php echo $form->textField($model,'Active',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Active'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->