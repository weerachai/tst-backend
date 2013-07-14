<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'employee-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'EmployeeId'); ?>
		<?php echo $form->textField($model, 'EmployeeId', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'EmployeeId'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'FirstName'); ?>
		<?php echo $form->textField($model, 'FirstName', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'FirstName'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'LastName'); ?>
		<?php echo $form->textField($model, 'LastName', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'LastName'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Active'); ?>
		<?php echo $form->textField($model, 'Active', array('maxlength' => 1)); ?>
		<?php echo $form->error($model,'Active'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->