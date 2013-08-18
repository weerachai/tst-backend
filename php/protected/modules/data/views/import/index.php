<?php
/* @var $this ImportController */

$this->breadcrumbs=array(
    $this->module->id => array('/'.$this->module->id),
	'นำข้อมูลเข้า',
);
?>

<h3>นำข้อมูลเข้า</h3>

<h5 style="color:green"><?php echo $message; ?></h5>

<div>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>

<div class="row">
<?php echo CHtml::label('เลือกตาราง: ',  'Table'); ?>
<?php echo CHtml::dropDownList('Table',  null, $tableList); ?>

<?php echo CHtml::label('เลือก folder: ',  'Folder'); ?>
<?php echo CHtml::dropDownList('Folder',  null, $folderList); ?>

<?php echo CHtml::label('ชนิดไฟล์: ',  'FileType'); ?>
<?php echo CHtml::dropDownList('FileType',  null, array('Text'=>'Text', 'Excel'=>'Excel')); ?>

<?php echo CHtml::label('เลือก ไฟล์: ',  'FileName'); ?>
<?php echo CHtml::dropDownList('FileName',  null, $fileList); ?>

<div>
<?php echo GxHtml::submitButton(Yii::t('app', 'ดำเนินการต่อ')); ?>
</div><!-- row -->
<?php $this->endWidget(); ?>
</div>
