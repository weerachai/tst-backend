<?php
/* @var $this SaleUnitController */

$this->breadcrumbs=array(
	'Sale Unit',
);
?>
<h1>ข้อมูลหน่วยขาย</h1>

<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sale-unit-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'sale-unit-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array(
            'class'=>'CDataColumn',
            'header'=>'ชื่อพืันที่ขาย',
            'name'=>'AreaName',
            'value'=>'$data->area->AreaName',
            'sortable'=>true,
            ),
		array(
            'class'=>'CDataColumn',
            'header'=>'Supervisor',
            'name'=>'Supervisor',
            'value'=>'$data->area->supervisor',
            'sortable'=>true,
            ),
		'SaleName',
		'SaleType',
		array(
            'class'=>'CDataColumn',
            'header'=>'รหัสอุปกรณ์',
            'name'=>'DeviceId',
            'value'=>'$data->device->DeviceId',
            'sortable'=>true,
            ),
		array(
            'class'=>'CDataColumn',
            'header'=>'รหัสผู้ใช้',
            'name'=>'Username',
            'value'=>'$data->device->Username',
            'sortable'=>true,
            ),
		'EmployeeId',
		array(
            'class'=>'CDataColumn',
            'header'=>'ชื่อพนักงานขาย',
            'name'=>'Employee',
            'value'=>'$data->employee',
            'sortable'=>true,
            ),
		array(
			'class' => 'CButtonColumn',
			'template'=>'{view}{delete}',
		),
	),
)); ?>
