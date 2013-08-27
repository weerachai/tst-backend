<?php

$this->breadcrumbs=array(
    'ข้อมูล' => array('/data/'),
	'Data File Browser' => array('index'),
	'Upload',
);

$this->menu = array(
	array('label'=>Yii::t('app', 'List Files'), 'url' => array('browse/index')),
);
?>

<h3>Upload Data File</h3>

<div class="form">

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'upload-form',
	'enableAjaxValidation' => false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
?>

<?php echo $form->fileFieldRow($model, 'upload_file'); ?>
<?php echo $form->dropDownListRow($model, 'folder', $folders); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Save')); ?>

<?php $this->endWidget(); ?>
</div><!-- form -->