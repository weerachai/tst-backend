<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'SaleId'); ?>
		<?php echo $form->textField($model, 'SaleId', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'SaleType'); ?>
		<?php echo $form->textField($model, 'SaleType', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'PromotionSku'); ?>
		<?php echo $form->textField($model, 'PromotionSku', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'PromotionGroup'); ?>
		<?php echo $form->textField($model, 'PromotionGroup', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'PromotionBill'); ?>
		<?php echo $form->textField($model, 'PromotionBill', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'PromotionAccu'); ?>
		<?php echo $form->textField($model, 'PromotionAccu', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'Vat'); ?>
		<?php echo $form->textField($model, 'Vat', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'OverStock'); ?>
		<?php echo $form->textField($model, 'OverStock', array('maxlength' => 1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'DayToClear'); ?>
		<?php echo $form->textField($model, 'DayToClear'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'UpdateAt'); ?>
		<?php echo $form->textField($model, 'UpdateAt'); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
