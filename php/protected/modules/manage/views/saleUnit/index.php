<?php
/* @var $this SaleUnitController */

$this->breadcrumbs=array(
      $this->module->id => array('/'.$this->module->id),
	'หน่วยขาย',
);
?>

<h3>ข้อมูลหน่วยขาย</h3>

<?php 
$columns = array(
      array(
      'class'=>'CDataColumn',
      'header'=>'ชื่อพืันที่ขาย',
      'name'=>'AreaName',
      'value'=>'$data->area->AreaName',
      'sortable'=>true,
      'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      array(
      'class'=>'CDataColumn',
      'header'=>'Supervisor',
      'name'=>'Supervisor',
      'value'=>'$data->area->supervisor',
      'sortable'=>true,
      'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      array(
      'name'=>'SaleName',
      'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      array(
      'name'=>'SaleType',
      'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      array(
      'class'=>'CDataColumn',
      'header'=>'รหัสอุปกรณ์',
      'name'=>'DeviceId',
      'value'=>'$data->device->DeviceId',
      'sortable'=>true,
      'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      array(
      'class'=>'CDataColumn',
      'header'=>'รหัสผู้ใช้',
      'name'=>'Username',
      'value'=>'$data->device->Username',
      'sortable'=>true,
      'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      'EmployeeId',
      array(
      'class'=>'CDataColumn',
      'header'=>'ชื่อพนักงานขาย',
      'name'=>'Employee',
      'value'=>'$data->employee',
      'sortable'=>true,
      'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template'=>'{view}{delete}',
            'buttons'=>array(
                  'view' => array(
                  'label'=>'แสดงรายละเอียดหน่วยขาย',
                ),
                  'delete' => array(
                  'label'=>'ยกเลิกความสัมพันธ์',
                ),
            ),
            'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
);

$this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id' => 'sale-unit-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
      'ajaxUpdate'=>false,
      'responsiveTable' => true,
      'enablePagination' => true,
      'pager' => array(
        'cssFile' => false,
        'header' => false,
        'firstPageLabel' => 'หน้าแรก',
        'prevPageLabel' => 'หน้าก่อน',
        'nextPageLabel' => 'หน้าถัดไป',
        'lastPageLabel' => 'หน้าสุดท้าย',
    ),  
//    'template' => "{items}",
      'type'=>'striped',
	'columns' => $columns,
)); ?>

<h3>เพิ่มข้อมูลหน่วยขาย</h3>
<div>
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
</div>
