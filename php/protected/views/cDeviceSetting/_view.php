<?php
/* @var $this CDeviceSettingController */
/* @var $data CDeviceSetting */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('SaleId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->SaleId), array('view', 'id'=>$data->SaleId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PromotionSku')); ?>:</b>
	<?php echo CHtml::encode($data->PromotionSku); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PromotionGroup')); ?>:</b>
	<?php echo CHtml::encode($data->PromotionGroup); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PromotionBill')); ?>:</b>
	<?php echo CHtml::encode($data->PromotionBill); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PromotionAccu')); ?>:</b>
	<?php echo CHtml::encode($data->PromotionAccu); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vat')); ?>:</b>
	<?php echo CHtml::encode($data->Vat); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('OverStock')); ?>:</b>
	<?php echo CHtml::encode($data->OverStock); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('DayToClear')); ?>:</b>
	<?php echo CHtml::encode($data->DayToClear); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('UpdateAt')); ?>:</b>
	<?php echo CHtml::encode($data->UpdateAt); ?>
	<br />

	*/ ?>

</div>