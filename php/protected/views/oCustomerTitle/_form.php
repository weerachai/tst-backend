<?php
/* @var $this OCustomerTitleController */
/* @var $model OCustomerTitle */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ocustomer-title-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'TitleName'); ?>
		<?php echo $form->textField($model,'TitleName',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'TitleName'); ?>
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