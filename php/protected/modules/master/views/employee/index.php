<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'พนักงาน' => array('index'),
	'จัดการ',
);

$this->menu = array(
		array('label'=>'เพิ่มพนักงาน', 'url'=>array('create')),
);
?>

<h3>จัดการพนักงาน</h3>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'data-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
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