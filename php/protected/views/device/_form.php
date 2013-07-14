<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'device-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'DeviceId'); ?>
		<?php echo $form->textField($model, 'DeviceId', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'DeviceId'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'DeviceKey'); ?>
		<?php echo $form->textField($model, 'DeviceKey', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'DeviceKey'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'SaleId'); ?>
		<?php echo $form->dropDownList($model, 'SaleId', 
			SaleUnit::model()->getOptions(),
			array('empty' => '(เลือกหน่วยขาย)')); ?>
		<?php echo $form->error($model,'SaleId'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Username'); ?>
		<?php echo $form->textField($model, 'Username', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'Username'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Password'); ?>
		<?php echo $form->passwordField($model, 'Password', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'Password'); ?>
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