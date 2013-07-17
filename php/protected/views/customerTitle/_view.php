<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('CustomerTitle')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->CustomerTitle), array('view', 'id' => $data->CustomerTitle)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('UpdateAt')); ?>:
	<?php echo GxHtml::encode($data->UpdateAt); ?>
	<br />

</div>