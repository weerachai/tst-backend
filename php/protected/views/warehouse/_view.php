<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('WarehouseId')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->WarehouseId), array('view', 'id' => $data->WarehouseId)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('WarehouseName')); ?>:
	<?php echo GxHtml::encode($data->WarehouseName); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('WarehouseType')); ?>:
	<?php echo GxHtml::encode($data->WarehouseType); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('UpdateAt')); ?>:
	<?php echo GxHtml::encode($data->UpdateAt); ?>
	<br />

</div>