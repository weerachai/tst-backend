<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'BankId'); ?>
		<?php echo $form->textField($model, 'BankId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'Bank'); ?>
		<?php echo $form->textField($model, 'Bank', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'Branch'); ?>
		<?php echo $form->textField($model, 'Branch', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'AccountNo'); ?>
		<?php echo $form->textField($model, 'AccountNo', array('maxlength' => 255)); ?>
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
