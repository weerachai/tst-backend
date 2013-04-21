<?php
/* @var $this BSaleAreaController */
/* @var $data BSaleArea */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('AreaId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->AreaId), array('view', 'id'=>$data->AreaId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('AreaName')); ?>:</b>
	<?php echo CHtml::encode($data->AreaName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Province')); ?>:</b>
	<?php echo CHtml::encode($data->Province); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('District')); ?>:</b>
	<?php echo CHtml::encode($data->District); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SubDistrict')); ?>:</b>
	<?php echo CHtml::encode($data->SubDistrict); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SupervisorId')); ?>:</b>
	<?php echo CHtml::encode($data->SupervisorId); ?>
	<br />


</div>