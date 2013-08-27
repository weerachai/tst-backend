<div class="form">


<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'sale-area-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'AreaId'); ?>
		<?php echo $form->textField($model, 'AreaId', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'AreaId'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'AreaName'); ?>
		<?php echo $form->textField($model, 'AreaName', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'AreaName'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'SupervisorId'); ?>
		<?php echo $form->dropDownList($model,'SupervisorId', 
			Employee::model()->getOptions(),
			array('empty' => '(ระบุหัวหน้า)')); ?>		<?php echo $form->error($model,'SupervisorId'); ?>
		</div><!-- row -->

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->