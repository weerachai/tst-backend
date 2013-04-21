<?php
/* @var $this SDeviceController */
/* @var $data SDevice */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('DeviceId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->DeviceId), array('view', 'id'=>$data->DeviceId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DeviceKey')); ?>:</b>
	<?php echo CHtml::encode($data->DeviceKey); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SaleId')); ?>:</b>
	<?php echo CHtml::encode($data->SaleId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Username')); ?>:</b>
	<?php echo CHtml::encode($data->Username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Password')); ?>:</b>
	<?php echo CHtml::encode($data->Password); ?>
	<br />


</div>