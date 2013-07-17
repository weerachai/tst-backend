<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'bank-account-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'Bank'); ?>
		<?php echo $form->textField($model, 'Bank', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'Bank'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Branch'); ?>
		<?php echo $form->textField($model, 'Branch', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'Branch'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'AccountNo'); ?>
		<?php echo $form->textField($model, 'AccountNo', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'AccountNo'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'UpdateAt'); ?>
		<?php echo $form->textField($model, 'UpdateAt'); ?>
		<?php echo $form->error($model,'UpdateAt'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->