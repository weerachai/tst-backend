<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'ค่ากำหนด' => array('index'),
	'แก้ไข',
);

$this->menu=array(
	array('label'=>'ค่ากำหนด', 'url'=>array('index')),
);
?>

<h3>แก้ไขค่ากำหนด</h3>

<div class="form">

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'config-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'DayToClear'); ?>
		<?php echo $form->textField($model, 'DayToClear', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'DayToClear'); ?>
		</div><!-- row -->

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->