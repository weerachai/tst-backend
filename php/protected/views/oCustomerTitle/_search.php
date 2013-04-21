<?php
/* @var $this OCustomerTitleController */
/* @var $model OCustomerTitle */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'TitleId'); ?>
		<?php echo $form->textField($model,'TitleId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TitleName'); ?>
		<?php echo $form->textField($model,'TitleName',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'UpdateAt'); ?>
		<?php echo $form->textField($model,'UpdateAt'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->