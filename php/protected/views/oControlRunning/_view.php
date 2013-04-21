<?php
/* @var $this OControlRunningController */
/* @var $data OControlRunning */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ControlId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ControlId), array('view', 'id'=>$data->ControlId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ControlName')); ?>:</b>
	<?php echo CHtml::encode($data->ControlName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Prefix')); ?>:</b>
	<?php echo CHtml::encode($data->Prefix); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('UpdateAt')); ?>:</b>
	<?php echo CHtml::encode($data->UpdateAt); ?>
	<br />


</div>