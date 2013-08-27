<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'Control Running' => array('index'),
	'แก้ไข',
);

$this->menu=array(
	array('label'=>'จัดการ Control Running', 'url'=>array('index')),
);
?>

<h3><?php echo 'แก้ไข Control No: "' . GxHtml::encode($model->control->ControlName) . '" สำหรับ ' . GxHtml::encode($model->saleUnit->SaleName); ?></h3>

<div class="form">

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'control-no-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'No'); ?>
		<?php echo $form->textField($model, 'No', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'No'); ?>
		</div><!-- row -->

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->