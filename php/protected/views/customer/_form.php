<?php
/* @var $this CustomerController */
/* @var $model Customer */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'customer-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'CustomerId'); ?>
		<?php echo $form->textField($model,'CustomerId',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'CustomerId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'DeviceId'); ?>
		<?php echo $form->textField($model,'DeviceId',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'DeviceId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SaleId'); ?>
		<?php echo $form->textField($model,'SaleId',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'SaleId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Title'); ?>
		<?php echo $form->textField($model,'Title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CustomerName'); ?>
		<?php echo $form->textField($model,'CustomerName',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'CustomerName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Type'); ?>
		<?php echo $form->textField($model,'Type',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Trip1'); ?>
		<?php echo $form->textField($model,'Trip1',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Trip1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Trip2'); ?>
		<?php echo $form->textField($model,'Trip2',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Trip2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Trip3'); ?>
		<?php echo $form->textField($model,'Trip3',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Trip3'); ?>
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
		<?php echo $form->labelEx($model,'ZipCode'); ?>
		<?php echo $form->textField($model,'ZipCode',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'ZipCode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'AddrNo'); ?>
		<?php echo $form->textField($model,'AddrNo',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'AddrNo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Moo'); ?>
		<?php echo $form->textField($model,'Moo',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Moo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Village'); ?>
		<?php echo $form->textField($model,'Village',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Village'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Soi'); ?>
		<?php echo $form->textField($model,'Soi',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Soi'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Road'); ?>
		<?php echo $form->textField($model,'Road',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Road'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Phone'); ?>
		<?php echo $form->textField($model,'Phone',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ContactPerson'); ?>
		<?php echo $form->textField($model,'ContactPerson',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'ContactPerson'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Promotion'); ?>
		<?php echo $form->textField($model,'Promotion',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Promotion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CreditTerm'); ?>
		<?php echo $form->textField($model,'CreditTerm'); ?>
		<?php echo $form->error($model,'CreditTerm'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CreditLimit'); ?>
		<?php echo $form->textField($model,'CreditLimit',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'CreditLimit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'OverCreditType'); ?>
		<?php echo $form->textField($model,'OverCreditType',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'OverCreditType'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Due'); ?>
		<?php echo $form->textField($model,'Due',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'Due'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'PoseCheck'); ?>
		<?php echo $form->textField($model,'PoseCheck',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'PoseCheck'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ReturnCheck'); ?>
		<?php echo $form->textField($model,'ReturnCheck',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'ReturnCheck'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'NewFlag'); ?>
		<?php echo $form->textField($model,'NewFlag',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'NewFlag'); ?>
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