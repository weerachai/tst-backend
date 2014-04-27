<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	'Master & Formula',
);
?>
<h3>Create New Master & Formula</h3>

<p>
<ul>
	<li><?php echo CHtml::link('หน่วยขาย และ Device',array('/master/saleUnit')); ?></li>
	<li><?php echo CHtml::link('Area',array('/master/saleArea')); ?></li>
	<li><?php echo CHtml::link('พนักงาน',array('/master/employee')); ?></li>
	<li><?php echo CHtml::link('Control Running',array('/master/controlNo')); ?></li>
	<?php if (Yii::app()->user->checkAccess('admin')): ?>
	<li><?php echo CHtml::link('Settings',array('/master/config')); ?></li>
	<?php endif; ?>
	<li><?php echo CHtml::link('สร้างประวัติการขาย',array('/master/history')); ?></li>
	<li><?php echo CHtml::link('สร้างสูตรโปรโมชั่น',array('/master/promotion')); ?></li>
</ul>
</p>