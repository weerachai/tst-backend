<?php
/* @var $this ImportController */

$this->breadcrumbs=array(
    'ข้อมูล' => array('/data/'),
    'นำข้อมูลเข้า',
);?>


<h3>นำข้อมูลเข้า</h3>
<div>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'enableAjaxValidation'=>true,
)); ?>
 
<?php 

$columns = array(
    array(
        'header'=>CHtml::encode('ชื่อ filed ของตาราง'),
        'name'=>'id',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ชื่อ filed ของไฟล์'),
        'type'=>'raw',
        'value'=>'CHtml::dropDownList("FieldList[$data[id]]",$data["id"],$this->grid->options)',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
);

Yii::import('bootstrap.widgets.TbGridView');
class MyGridView extends TbGridView {
    public $options;
}

$this->widget('MyGridView', array(
	'id' => 'data-grid',
    'ajaxUpdate'=>false,
	'type'=>'striped bordered condensed',
	'dataProvider' => $dataProvider,
	'enablePagination' => false,
	'columns' => $columns,
	'options' => $options,
));
?>

<?php echo CHtml::hiddenField('Table', $table); ?>
<?php echo CHtml::hiddenField('Folder', $folder); ?>
<?php echo CHtml::hiddenField('FileName', $fileName); ?>
<?php echo CHtml::hiddenField('FileType', $fileType); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'ดำเนินการ')); ?>
<?php $this->endWidget(); ?>
</div>