<?php
/* @var $this SaleUnitController */

$this->breadcrumbs=array(
      $this->module->id => array('/'.$this->module->id),
	'หน่วยขาย',
);
?>

<h1>ข้อมูลหน่วยขาย</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'sale-unit-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
      'ajaxUpdate'=>false,
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

<h3>เพิ่มข้อมูลหน่วยขาย</h3>

<?php $form = $this->beginWidget('CActiveForm'); ?>

<div class="row">
<?php echo CHtml::label('พื้นที่ขาย: ',  'AreaId'); ?>
<?php echo CHtml::dropDownList('AreaId',  null, SaleArea::model()->getOptions()); ?>

<?php echo CHtml::label('หน่วยขาย: ',  'SaleId'); ?>
<?php echo CHtml::dropDownList('SaleId',  null, SaleUnit::model()->getAvailableOptions()); ?>

<?php echo CHtml::label('พนักงานขาย: ',  'EmployeeId'); ?>
<?php echo CHtml::dropDownList('EmployeeId',  null, Employee::model()->getAvailableOptions()); ?>

<?php echo GxHtml::submitButton(Yii::t('app', 'กำหนดความสัมพันธ์')); ?>
</div><!-- row -->
<?php $this->endWidget(); ?>
