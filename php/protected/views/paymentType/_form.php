<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'payment-type-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'PaymentType'); ?>
		<?php echo $form->textField($model, 'PaymentType', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'PaymentType'); ?>
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