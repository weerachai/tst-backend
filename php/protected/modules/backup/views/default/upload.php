<?php
$this->breadcrumbs=array(
    'ข้อมูล' => array('/data/'),
	'Backup และ Restore' => array('index'),
	'Upload',
);?>

<h3>Upload Backup File</h3>

<div class="form">

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'install-form',
	'enableAjaxValidation' => true,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
?>

<?php echo $form->fileFieldRow($model, 'upload_file'); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Save')); ?>

<?php $this->endWidget(); ?>
</div><!-- form -->