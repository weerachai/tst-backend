<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('DeviceId')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->DeviceId), array('view', 'id' => $data->DeviceId)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('DeviceKey')); ?>:
	<?php echo GxHtml::encode($data->DeviceKey); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('SaleId')); ?>:
	<?php echo GxHtml::encode($data->SaleId); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('Username')); ?>:
	<?php echo GxHtml::encode($data->Username); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('Password')); ?>:
	<?php echo GxHtml::encode($data->Password); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('UpdateAt')); ?>:
	<?php echo GxHtml::encode($data->UpdateAt); ?>
	<br />

</div>