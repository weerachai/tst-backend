<?php
/* @var $this CustomerController */

$this->breadcrumbs = array(
    $this->module->id => array('/'.$this->module->id),
	'ร้านค้า' => array('index'),
	'รายชื่อ',
);
?>

<h3>รายชื่อร้านค้า ในเขต<?php echo $title; ?></h3>

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
    'enablePagination' => true,
    'pager' => array(
        'cssFile' => false,
        'header' => false,
        'firstPageLabel' => 'หน้าแรก',
        'prevPageLabel' => 'หน้าก่อน',
        'nextPageLabel' => 'หน้าถัดไป',
        'lastPageLabel' => 'หน้าสุดท้าย',
    ),  
//  'template' => "{items}",
	'columns' => $columns,
));

 ?>
