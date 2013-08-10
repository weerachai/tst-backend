<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('DeliverNo')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->DeliverNo), array('view', 'id' => $data->DeliverNo)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('RequestNo')); ?>:
	<?php echo GxHtml::encode($data->RequestNo); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('SaleId')); ?>:
	<?php echo GxHtml::encode($data->SaleId); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('WarehouseId')); ?>:
	<?php echo GxHtml::encode($data->WarehouseId); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('WarehouseName')); ?>:
	<?php echo GxHtml::encode($data->WarehouseName); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('WarehouseType')); ?>:
	<?php echo GxHtml::encode($data->WarehouseType); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('DeliverDate')); ?>:
	<?php echo GxHtml::encode($data->DeliverDate); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('Total')); ?>:
	<?php echo GxHtml::encode($data->Total); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('Status')); ?>:
	<?php echo GxHtml::encode($data->Status); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('UpdateAt')); ?>:
	<?php echo GxHtml::encode($data->UpdateAt); ?>
	<br />
	*/ ?>

</div>