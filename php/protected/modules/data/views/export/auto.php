<?php
$this->breadcrumbs=array(
    'ข้อมูล' => array('/data/'),
	'นำข้อมูลออก' => array('index'),
	'กำหนดเวลา นำข้อมูลออก',
);
$this->menu = array(
	array('label'=>Yii::t('app', 'นำข้อมูลออก'), 'url' => array('index')),
	array('label'=>Yii::t('app', 'Stop Auto Export'), 'url'=>'#', 'linkOptions' => array('submit' => array('stop'), 'confirm'=>'กรุณายืนยัน')),
);
?>

<h3>กำหนดเวลา นำข้อมูลออก</h3>

<div class="form">

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'install-form',
	'enableAjaxValidation' => true,
));
?>

<?php echo $form->dropDownListRow($model, 'tables', $tableList, array('size' => '10', 'multiple' => 'multiple')); ?>

<?php echo $form->dropDownListRow($model, 'type', array('txt'=>'Text', 'xls'=>'Excel')); ?>

<?php echo $form->dropDownListRow($model, 'folder', $folderList); ?>

<?php echo $form->textFieldRow($model, 'min'); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Start')); ?>

<?php $this->endWidget(); ?>
</div><!-- form -->