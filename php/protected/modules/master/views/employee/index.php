<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'พนักงาน',
);

$this->menu = array(
		array('label'=>'เพิ่มพนักงาน', 'url'=>array('create')),
);
?>

<h3>พนักงาน</h3>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'data-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'type'=>'striped bordered condensed',
	'enablePagination' => true,
    'pager' => array(
        'cssFile' => false,
        'header' => false,
        'firstPageLabel' => 'หน้าแรก',
        'prevPageLabel' => 'หน้าก่อน',
        'nextPageLabel' => 'หน้าถัดไป',
        'lastPageLabel' => 'หน้าสุดท้าย',
    ),  
   	'columns' => array(
		'EmployeeId',
		'FirstName',
		'LastName',
//		'Active',
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>