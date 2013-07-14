<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'device-setting-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'SaleId'); ?>
		<?php echo $form->textField($model, 'SaleId', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'SaleId'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'SaleType'); ?>
		<?php echo $form->textField($model, 'SaleType', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'SaleType'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'PromotionSku'); ?>
		<?php echo $form->textField($model, 'PromotionSku', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'PromotionSku'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'PromotionGroup'); ?>
		<?php echo $form->textField($model, 'PromotionGroup', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'PromotionGroup'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'PromotionBill'); ?>
		<?php echo $form->textField($model, 'PromotionBill', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'PromotionBill'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'PromotionAccu'); ?>
		<?php echo $form->textField($model, 'PromotionAccu', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'PromotionAccu'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Vat'); ?>
		<?php echo $form->dropDownList($model, 'Vat', array('bill' => 'ท้ายบิล', 'sku' => 'รายสินค้า')); ?>
		<?php echo $form->error($model,'Vat'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'OverStock'); ?>
		<?php echo $form->dropDownList($model, 'OverStock', array('Y' => 'Yes', 'N' => 'No')); ?>
		<?php echo $form->error($model,'OverStock'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'DayToClear'); ?>
		<?php echo $form->textField($model, 'DayToClear'); ?>
		<?php echo $form->error($model,'DayToClear'); ?>
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