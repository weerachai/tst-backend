<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('EmployeeId')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->EmployeeId), array('view', 'id' => $data->EmployeeId)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('FirstName')); ?>:
	<?php echo GxHtml::encode($data->FirstName); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('LastName')); ?>:
	<?php echo GxHtml::encode($data->LastName); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('Active')); ?>:
	<?php echo GxHtml::encode($data->Active); ?>
	<br />

</div>