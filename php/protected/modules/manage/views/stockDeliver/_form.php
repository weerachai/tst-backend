<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'stock-deliver-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'RequestNo'); ?>
		<?php echo $form->textField($model, 'RequestNo', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'RequestNo'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'DeliverNo'); ?>
		<?php echo $form->textField($model, 'DeliverNo', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'DeliverNo'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'SaleId'); ?>
		<?php echo $form->textField($model, 'SaleId', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'SaleId'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'WarehouseId'); ?>
		<?php echo $form->textField($model, 'WarehouseId', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'WarehouseId'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'WarehouseName'); ?>
		<?php echo $form->textField($model, 'WarehouseName', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'WarehouseName'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'WarehouseType'); ?>
		<?php echo $form->textField($model, 'WarehouseType', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'WarehouseType'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'DeliverDate'); ?>
		<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'DeliverDate',
			'value' => $model->DeliverDate,
			'options' => array(
				'showButtonPanel' => true,
				'changeYear' => true,
				'dateFormat' => 'yy-mm-dd',
				),
			));
; ?>
		<?php echo $form->error($model,'DeliverDate'); ?>
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

		<label><?php echo GxHtml::encode($model->getRelationLabel('deliverDetails')); ?></label>
		<?php echo $form->checkBoxList($model, 'deliverDetails', GxHtml::encodeEx(GxHtml::listDataEx(DeliverDetail::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->