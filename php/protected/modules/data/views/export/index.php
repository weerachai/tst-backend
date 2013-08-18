<?php
/* @var $this ExportController */

$this->breadcrumbs=array(
    $this->module->id => array('/'.$this->module->id),
	'นำข้อมูลออก',
);
?>

<h3>นำข้อมูลออก</h3>
<div>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>

<div class="row">
<?php echo CHtml::label('เลือกตาราง: ',  'Table'); ?>
<?php echo CHtml::dropDownList('Table',  null, $tableList); ?>

<?php echo CHtml::label('เลือก folder: ',  'Folder'); ?>
<?php echo CHtml::dropDownList('Folder',  null, $folderList); ?>

<?php echo CHtml::label('ชื่อไฟล์: ',  'FileName'); ?>
<?php echo CHtml::textField('FileName',  $defaultFileName); ?>

<?php echo CHtml::label('ชนิดไฟล์: ',  'FileType'); ?>
<?php echo CHtml::dropDownList('FileType',  null, array('Text'=>'Text', 'Excel'=>'Excel')); ?>

<?php echo CHtml::label('เลือก Fileds: ',  'FieldList'); ?>
<?php echo CHtml::dropDownList('FieldList',  null, $fieldList, array('size' => '10', 'multiple' => 'multiple')); ?>
</div>

<div>
<?php echo GxHtml::submitButton(Yii::t('app', 'ดำเนินการ')); ?>
</div><!-- row -->
<?php $this->endWidget(); ?>
</div>
