<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'Area' => array('index'),
	GxHtml::valueEx($model),
);

$this->menu=array(
	array('label'=>'จัดการ Area', 'url'=>array('index')),
	array('label'=>'แก้ไข Area', 'url'=>array('update', 'id' => $model->AreaId)),
	array('label'=>'ลบ Area', 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->AreaId), 'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h3><?php echo 'รายละเอียด' . GxHtml::encode(GxHtml::valueEx($model)); ?></h3>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
    'attributes'=>array(
	    array('name'=>'AreaId', 'label'=>'AreaId'),
	    array('name'=>'AreaName', 'label'=>'ชื่อพื้นที่ขาย'),
	    array('name'=>'SupervisorId', 'label'=>'SupervisorId'),
	    array('name'=>'supervisor', 'label'=>'ชื่อ Supervisor'),
    ),
)); ?>
