<div class="form">


<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
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
		<?php echo $form->labelEx($model,'DeviceId'); ?>
		<?php echo $form->textField($model, 'DeviceId', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'DeviceId'); ?>
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
		<p class="hint"><?php if(!isset($buttons)) echo 'ป้อนหากต้องการเปลี่ยนรหัสผ่าน'; ?></p>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Password2'); ?>
		<?php echo $form->passwordField($model, 'Password2', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'Password2'); ?>
		<p class="hint"><?php if(!isset($buttons)) echo 'ป้อนอีกครั้งหากต้องการเปลี่ยนรหัสผ่าน'; ?></p>
		</div><!-- row -->

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->