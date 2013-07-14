<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('SaleId')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->SaleId), array('view', 'id' => $data->SaleId)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('SaleName')); ?>:
	<?php echo GxHtml::encode($data->SaleName); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('SaleType')); ?>:
	<?php echo GxHtml::encode($data->SaleType); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('EmployeeId')); ?>:
	<?php echo GxHtml::encode($data->EmployeeId); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('AreaId')); ?>:
	<?php echo GxHtml::encode($data->AreaId); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('Active')); ?>:
	<?php echo GxHtml::encode($data->Active); ?>
	<br />

</div>