<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'CustomerId'); ?>
		<?php echo $form->textField($model, 'CustomerId', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'SaleId'); ?>
		<?php echo $form->textField($model, 'SaleId', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'Title'); ?>
		<?php echo $form->textField($model, 'Title', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'CustomerName'); ?>
		<?php echo $form->textField($model, 'CustomerName', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'Type'); ?>
		<?php echo $form->textField($model, 'Type', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'Trip1'); ?>
		<?php echo $form->textField($model, 'Trip1', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'Trip2'); ?>
		<?php echo $form->textField($model, 'Trip2', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'Trip3'); ?>
		<?php echo $form->textField($model, 'Trip3', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'Province'); ?>
		<?php echo $form->textField($model, 'Province', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'District'); ?>
		<?php echo $form->textField($model, 'District', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'SubDistrict'); ?>
		<?php echo $form->textField($model, 'SubDistrict', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'ZipCode'); ?>
		<?php echo $form->textField($model, 'ZipCode', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'AddrNo'); ?>
		<?php echo $form->textField($model, 'AddrNo', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'Moo'); ?>
		<?php echo $form->textField($model, 'Moo', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'Village'); ?>
		<?php echo $form->textField($model, 'Village', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'Soi'); ?>
		<?php echo $form->textField($model, 'Soi', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'Road'); ?>
		<?php echo $form->textField($model, 'Road', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'Phone'); ?>
		<?php echo $form->textField($model, 'Phone', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'ContactPerson'); ?>
		<?php echo $form->textField($model, 'ContactPerson', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'CreditTerm'); ?>
		<?php echo $form->textField($model, 'CreditTerm'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'CreditLimit'); ?>
		<?php echo $form->textField($model, 'CreditLimit', array('maxlength' => 20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'OverCreditType'); ?>
		<?php echo $form->textField($model, 'OverCreditType', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'Due'); ?>
		<?php echo $form->textField($model, 'Due', array('maxlength' => 20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'PoseCheck'); ?>
		<?php echo $form->textField($model, 'PoseCheck', array('maxlength' => 20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'ReturnCheck'); ?>
		<?php echo $form->textField($model, 'ReturnCheck', array('maxlength' => 20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'NewFlag'); ?>
		<?php echo $form->textField($model, 'NewFlag', array('maxlength' => 1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'DeleteFlag'); ?>
		<?php echo $form->textField($model, 'DeleteFlag', array('maxlength' => 1)); ?>
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
