<?php
$this->breadcrumbs=array(
    'ข้อมูล' => array('/data/'),
	'Backup และ Restore' => array('index'),
	'กำหนดเวลา Backup',
);?>

<h3>กำหนดเวลา Backup File</h3>

<div class="form">

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'install-form',
	'enableAjaxValidation' => true,
));
?>

<?php echo $form->textFieldRow($model, 'min'); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Start')); ?>

<?php $this->endWidget(); ?>
</div><!-- form -->