<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('BankId')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->BankId), array('view', 'id' => $data->BankId)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('Bank')); ?>:
	<?php echo GxHtml::encode($data->Bank); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('Branch')); ?>:
	<?php echo GxHtml::encode($data->Branch); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('AccountNo')); ?>:
	<?php echo GxHtml::encode($data->AccountNo); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('UpdateAt')); ?>:
	<?php echo GxHtml::encode($data->UpdateAt); ?>
	<br />

</div>