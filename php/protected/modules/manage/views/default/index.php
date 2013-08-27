<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	'กำหนดความสัมพันธ์',
);
?>
<h3>กำหนดความสัมพันธ์ของข้อมูล</h3>

<p>
<ul>
	<li><?php echo CHtml::link('กำหนดเขตการขาย',array('saleUnit/')); //7.1 ?></li>
	<li><?php echo CHtml::link('กำหนดร้านค้า',array('customer/')); //7.2 ?></li>
	<li><?php echo CHtml::link('กำหนดทริป',array('trip/')); //7.3 ?></li>
	<li><?php echo CHtml::link('กำหนด Running No.',array('running/')); //7.4 ?></li>
	<li><?php echo CHtml::link('กำหนดรายการตรวจสต็อคสินค้า',array('stockCheck/')); //7.6 ?></li>
	<li><?php echo CHtml::link('เตรียมสถานะใบสั่งซื้อ',array('order/')); //7.7 ?></li>
	<li><?php echo CHtml::link('กำหนดโปรโมชั่น',array('promotion/')); //7.10 ?></li>
	<li><?php echo CHtml::link('กำหนดสต็อตตั้งต้น',array('startStock/')); //7.11 ?></li>
	<li><?php echo CHtml::link('สร้างใบส่งสินค้า',array('deliver/')); //7.12 ?></li>
</ul>
</p>