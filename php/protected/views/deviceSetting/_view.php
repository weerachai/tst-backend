<div class="view">

	<?php echo GxHtml::encode($data->getAttributeLabel('SaleId')); ?>:
	<?php echo GxHtml::link(GxHtml::encode($data->SaleId), array('view', 'id' => $data->SaleId)); ?>
	<br />

	<?php echo GxHtml::encode($data->getAttributeLabel('SaleType')); ?>:
	<?php echo GxHtml::encode($data->SaleType); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('PromotionSku')); ?>:
	<?php echo GxHtml::encode($data->PromotionSku); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('PromotionGroup')); ?>:
	<?php echo GxHtml::encode($data->PromotionGroup); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('PromotionBill')); ?>:
	<?php echo GxHtml::encode($data->PromotionBill); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('PromotionAccu')); ?>:
	<?php echo GxHtml::encode($data->PromotionAccu); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('Vat')); ?>:
	<?php echo GxHtml::encode($data->Vat); ?>
	<br />
	<?php /*
	<?php echo GxHtml::encode($data->getAttributeLabel('OverStock')); ?>:
	<?php echo GxHtml::encode($data->OverStock); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('DayToClear')); ?>:
	<?php echo GxHtml::encode($data->DayToClear); ?>
	<br />
	<?php echo GxHtml::encode($data->getAttributeLabel('UpdateAt')); ?>:
	<?php echo GxHtml::encode($data->UpdateAt); ?>
	<br />
	*/ ?>

</div>