<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'warehouse-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

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
		<?php echo $form->dropDownList($model, 'WarehouseType', array('คลังใหญ่' => 'คลังใหญ่', 'คลังรถ' => 'คลังรถ')); ?>
		<?php echo $form->error($model,'WarehouseType'); ?>
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