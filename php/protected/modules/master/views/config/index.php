<?php
$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'ค่ากำหนด'
);

$this->menu=array(
	array('label'=>'แก้ไขค่า', 'url'=>array('update')),
);
?>
<h3>กำหนดค่า</h3>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
    'attributes'=>array(
	    array('name'=>'DayToClear', 'label'=>'จำนวนวันเก็บข้อมูลบน Device'),
    ),
)); ?>
