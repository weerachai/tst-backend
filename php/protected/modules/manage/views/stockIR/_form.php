<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'stock-ir-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'IRNo'); ?>
		<?php echo $form->textField($model, 'IRNo', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'IRNo'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'SaleId'); ?>
		<?php echo $form->textField($model, 'SaleId', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'SaleId'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'IRDate'); ?>
		<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'IRDate',
			'value' => $model->IRDate,
			'options' => array(
				'showButtonPanel' => true,
				'changeYear' => true,
				'dateFormat' => 'yy-mm-dd',
				),
			));
; ?>
		<?php echo $form->error($model,'IRDate'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Total'); ?>
		<?php echo $form->textField($model, 'Total', array('maxlength' => 10)); ?>
		<?php echo $form->error($model,'Total'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Status'); ?>
		<?php echo $form->textField($model, 'Status', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'Status'); ?>
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