<?php
/* @var $this ImportController */

$this->breadcrumbs=array(
    'ข้อมูล' => array('/data/'),
	'นำข้อมูลเข้า',
);?>

<h3>นำข้อมูลเข้า</h3>

<h5 style="color:green"><?php echo $message; ?></h5>
<h5 style="color:red"><?php echo $error; ?></h5>

<div>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>

<div class="row">
<?php echo CHtml::label('เลือกตาราง: ',  'Table'); ?>
<?php echo CHtml::dropDownList('Table',  null, $tableList); ?>

<?php echo CHtml::label('เลือก folder: ',  'Folder'); ?>
<?php echo CHtml::dropDownList('Folder',  null, $folderList, array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getFileList'),
						'dataType'=>'json',
 		                'data'=>array('Folder'=>'js:this.value'),
 		                'success'=>'function(data) {
                    		$("#FileName").html(data.fileList);
                		}',
					))); ?>

<?php echo CHtml::label('เลือก ไฟล์: ',  'FileName'); ?>
<?php echo CHtml::dropDownList('FileName',  null, $fileList); ?>

<div>
<?php echo GxHtml::submitButton(Yii::t('app', 'ดำเนินการต่อ')); ?>
</div><!-- row -->
<?php $this->endWidget(); ?>
</div>
