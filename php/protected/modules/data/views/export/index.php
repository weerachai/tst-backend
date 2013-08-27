<?php
/* @var $this ExportController */

$this->breadcrumbs=array(
    'ข้อมูล' => array('/data/'),
	'นำข้อมูลออก',
);
$this->menu = array(
	array('label'=>Yii::t('app', 'Auto Export'), 'url' => array('auto')),
	array('label'=>Yii::t('app', 'Stop Auto Export'), 'url'=>'#', 'linkOptions' => array('submit' => array('stop'), 'confirm'=>'กรุณายืนยัน')),
);
?>

<h3>นำข้อมูลออก</h3>
<div>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>

<div class="row">
<?php echo CHtml::label('เลือกตาราง: ',  'Table'); ?>
<?php echo CHtml::dropDownList('Table',  null, $tableList, array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getFieldList'),
						'dataType'=>'json',
 		                'data'=>array('Table'=>'js:this.value'),
 		                'success'=>'function(data) {
                    		$("#FieldList").html(data.fieldList);
                		}',
					))); ?>

<?php echo CHtml::label('เลือก folder: ',  'Folder'); ?>
<?php echo CHtml::dropDownList('Folder',  null, $folderList); ?>

<?php echo CHtml::label('ชื่อไฟล์: ',  'FileName'); ?>
<?php echo CHtml::textField('FileName',  $defaultFileName); ?>

<?php echo CHtml::label('ชนิดไฟล์: ',  'FileType'); ?>
<?php echo CHtml::dropDownList('FileType',  null, array('txt'=>'Text', 'xls'=>'Excel')); ?>

<?php echo CHtml::label('เลือก Fileds: ',  'FieldList'); ?>
<?php echo CHtml::dropDownList('FieldList',  null, $fieldList, array('size' => '10', 'multiple' => 'multiple')); ?>
</div>

<div>
<?php echo GxHtml::submitButton(Yii::t('app', 'ดำเนินการ')); ?>
</div><!-- row -->
<?php $this->endWidget(); ?>
</div>
