<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'sale-unit-form',
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
		<?php echo $form->labelEx($model,'SaleName'); ?>
		<?php echo $form->textField($model, 'SaleName', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'SaleName'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'SaleType'); ?>
		<?php echo $form->dropDownList($model, 'SaleType', array('เครดิต'=>'เครดิต','หน่วยรถ'=>'หน่วยรถ')); ?>
		<?php echo $form->error($model,'SaleType'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'EmployeeId'); ?>
		<?php echo $form->dropDownList($model,'EmployeeId',
			Employee::model()->getOptions(),
			array('empty' => '(ระบุพนักงานขาย)')); ?>		
		<?php echo $form->error($model,'EmployeeId'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'AreaId'); ?>
		<?php echo $form->dropDownList($model, 'AreaId', SaleArea::model()->getOptions()); ?>
		<?php echo $form->error($model,'AreaId'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Active'); ?>
		<?php echo $form->dropDownList($model,'EmployeeId',array('Y'=>'Yes','N'=>'No')); ?>	
		<?php echo $form->error($model,'Active'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->