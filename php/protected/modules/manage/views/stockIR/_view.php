<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('IRNo')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->IRNo), array('view', 'id' => $data->IRNo)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('SaleId')); ?>:
	<?php echo GxHtml::encode($data->SaleId); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('IRDate')); ?>:
	<?php echo GxHtml::encode($data->IRDate); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('Total')); ?>:
	<?php echo GxHtml::encode($data->Total); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('Status')); ?>:
	<?php echo GxHtml::encode($data->Status); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('UpdateAt')); ?>:
	<?php echo GxHtml::encode($data->UpdateAt); ?>
	<br />

</div>