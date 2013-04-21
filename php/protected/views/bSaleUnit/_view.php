<?php
/* @var $this BSaleUnitController */
/* @var $data BSaleUnit */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('SaleId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->SaleId), array('view', 'id'=>$data->SaleId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SaleName')); ?>:</b>
	<?php echo CHtml::encode($data->SaleName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SaleType')); ?>:</b>
	<?php echo CHtml::encode($data->SaleType); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('EmployeeId')); ?>:</b>
	<?php echo CHtml::encode($data->EmployeeId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('AreaId')); ?>:</b>
	<?php echo CHtml::encode($data->AreaId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Active')); ?>:</b>
	<?php echo CHtml::encode($data->Active); ?>
	<br />


</div>