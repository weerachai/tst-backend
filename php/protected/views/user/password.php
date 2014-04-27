<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model) => array('view', 'id' => GxActiveRecord::extractPkValue($model, true)),
	Yii::t('app', 'Change Password'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'View') . ' ' . $model->label(), 'url'=>array('index')),
);
?>

<h3>เปลี่ยนรหัสผ่าน</h3>
<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'user-form',
	'enableAjaxValidation' => false,
));
?>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model, 'password', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'password'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'repeat_password'); ?>
		<?php echo $form->passwordField($model, 'repeat_password', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'repeat_password'); ?>
		</div><!-- row -->

	<div class="row buttons">
		<?php echo CHtml::submitButton('Change'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->