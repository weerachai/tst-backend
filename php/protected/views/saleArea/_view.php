<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('AreaId')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->AreaId), array('view', 'id' => $data->AreaId)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('AreaName')); ?>:
	<?php echo GxHtml::encode($data->AreaName); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('Province')); ?>:
	<?php echo GxHtml::encode($data->Province); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('District')); ?>:
	<?php echo GxHtml::encode($data->District); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('SubDistrict')); ?>:
	<?php echo GxHtml::encode($data->SubDistrict); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('SupervisorId')); ?>:
	<?php echo GxHtml::encode($data->SupervisorId); ?>
	<br />

</div>