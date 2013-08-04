<?php
/* @var $this TripController */

$this->breadcrumbs = array(
    $this->module->id => array('/'.$this->module->id),
	'ทริป' => array('index'),
	'รายชื่อ',
);
?>

<h3>รายชื่อร้านค้า สำหรับทริป<?php echo $trip; ?> ในเขต<?php echo $title; ?></h3>


<?php 
$columns = array(
    array(
        'header'=>CHtml::encode('รหัสร้านค้า'),
        'name'=>'CustomerId',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ชื่อร้านค้า'),
        'name'=>'CustomerName',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
);

$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'id'=>'customer-grid',
	'type' => 'striped',
	'dataProvider' => $dataProvider,
	'template' => "{items}",
	'columns' => $columns,
));

 ?>
