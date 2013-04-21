<?php
/* @var $this OCustomerTitleController */
/* @var $data OCustomerTitle */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('TitleId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->TitleId), array('view', 'id'=>$data->TitleId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TitleName')); ?>:</b>
	<?php echo CHtml::encode($data->TitleName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('UpdateAt')); ?>:</b>
	<?php echo CHtml::encode($data->UpdateAt); ?>
	<br />


</div>