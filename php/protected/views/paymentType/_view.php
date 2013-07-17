<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('PaymentType')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->PaymentType), array('view', 'id' => $data->PaymentType)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('UpdateAt')); ?>:
	<?php echo GxHtml::encode($data->UpdateAt); ?>
	<br />

</div>