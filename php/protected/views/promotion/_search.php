<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'PromotionGroup'); ?>
		<?php echo $form->textField($model, 'PromotionGroup', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'PromotionId'); ?>
		<?php echo $form->textField($model, 'PromotionId', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'StartDate'); ?>
		<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'StartDate',
			'value' => $model->StartDate,
			'options' => array(
				'showButtonPanel' => true,
				'changeYear' => true,
				'dateFormat' => 'yy-mm-dd',
				),
			));
; ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'EndDate'); ?>
		<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'EndDate',
			'value' => $model->EndDate,
			'options' => array(
				'showButtonPanel' => true,
				'changeYear' => true,
				'dateFormat' => 'yy-mm-dd',
				),
			));
; ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'PromotionType'); ?>
		<?php echo $form->textField($model, 'PromotionType', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'ProductOrGrpId'); ?>
		<?php echo $form->textField($model, 'ProductOrGrpId', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'MinAmount'); ?>
		<?php echo $form->textField($model, 'MinAmount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'MinSku'); ?>
		<?php echo $form->textField($model, 'MinSku'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'MinQty'); ?>
		<?php echo $form->textField($model, 'MinQty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'Pack'); ?>
		<?php echo $form->textField($model, 'Pack', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'DiscBaht'); ?>
		<?php echo $form->textField($model, 'DiscBaht'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'DiscPerAmount'); ?>
		<?php echo $form->textField($model, 'DiscPerAmount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'DiscPerQty'); ?>
		<?php echo $form->textField($model, 'DiscPerQty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'DiscPer1'); ?>
		<?php echo $form->textField($model, 'DiscPer1'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'DiscPer2'); ?>
		<?php echo $form->textField($model, 'DiscPer2'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'DiscPer3'); ?>
		<?php echo $form->textField($model, 'DiscPer3'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'FreeType'); ?>
		<?php echo $form->textField($model, 'FreeType', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'FreeProductOrGrpId'); ?>
		<?php echo $form->textField($model, 'FreeProductOrGrpId', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'FreeQty'); ?>
		<?php echo $form->textField($model, 'FreeQty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'FreePack'); ?>
		<?php echo $form->textField($model, 'FreePack', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'FreePerAmount'); ?>
		<?php echo $form->textField($model, 'FreePerAmount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'FreePerQty'); ?>
		<?php echo $form->textField($model, 'FreePerQty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'FreeBaht'); ?>
		<?php echo $form->textField($model, 'FreeBaht'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'Formula'); ?>
		<?php echo $form->textField($model, 'Formula', array('maxlength' => 255)); ?>
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
