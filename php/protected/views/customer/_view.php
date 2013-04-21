<?php
/* @var $this CustomerController */
/* @var $data Customer */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('CustomerId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->CustomerId), array('view', 'id'=>$data->CustomerId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DeviceId')); ?>:</b>
	<?php echo CHtml::encode($data->DeviceId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SaleId')); ?>:</b>
	<?php echo CHtml::encode($data->SaleId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Title')); ?>:</b>
	<?php echo CHtml::encode($data->Title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CustomerName')); ?>:</b>
	<?php echo CHtml::encode($data->CustomerName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Type')); ?>:</b>
	<?php echo CHtml::encode($data->Type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Trip1')); ?>:</b>
	<?php echo CHtml::encode($data->Trip1); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Trip2')); ?>:</b>
	<?php echo CHtml::encode($data->Trip2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Trip3')); ?>:</b>
	<?php echo CHtml::encode($data->Trip3); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('ZipCode')); ?>:</b>
	<?php echo CHtml::encode($data->ZipCode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('AddrNo')); ?>:</b>
	<?php echo CHtml::encode($data->AddrNo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Moo')); ?>:</b>
	<?php echo CHtml::encode($data->Moo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Village')); ?>:</b>
	<?php echo CHtml::encode($data->Village); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Soi')); ?>:</b>
	<?php echo CHtml::encode($data->Soi); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Road')); ?>:</b>
	<?php echo CHtml::encode($data->Road); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Phone')); ?>:</b>
	<?php echo CHtml::encode($data->Phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ContactPerson')); ?>:</b>
	<?php echo CHtml::encode($data->ContactPerson); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Promotion')); ?>:</b>
	<?php echo CHtml::encode($data->Promotion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CreditTerm')); ?>:</b>
	<?php echo CHtml::encode($data->CreditTerm); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CreditLimit')); ?>:</b>
	<?php echo CHtml::encode($data->CreditLimit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('OverCreditType')); ?>:</b>
	<?php echo CHtml::encode($data->OverCreditType); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Due')); ?>:</b>
	<?php echo CHtml::encode($data->Due); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PoseCheck')); ?>:</b>
	<?php echo CHtml::encode($data->PoseCheck); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ReturnCheck')); ?>:</b>
	<?php echo CHtml::encode($data->ReturnCheck); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NewFlag')); ?>:</b>
	<?php echo CHtml::encode($data->NewFlag); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('UpdateAt')); ?>:</b>
	<?php echo CHtml::encode($data->UpdateAt); ?>
	<br />

	*/ ?>

</div>