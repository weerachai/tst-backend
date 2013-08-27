<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	'ข้อมูล',
);
?>
<h3>จัดการข้อมูล</h3>

<p>
<ul>
	<li><?php echo CHtml::link('Backup และ Restore',array('/backup')); ?></li>
	<li><?php echo CHtml::link('Backup อัตโนมัติ',array('/data/backup')); ?></li>
	<li><?php echo CHtml::link('นำข้อมูลเข้า',array('/data/import')); ?></li>
	<li><?php echo CHtml::link('นำข้อมูลออก',array('/data/export')); ?></li>
	<li><?php echo CHtml::link('Data File Browser', array('/data/browse')); ?></li>
</ul>
</p>

<p>
