<?php
$this->breadcrumbs=array(
	'Master & Formula' => array('/master/'),
	'ตรวจสต็อค/สร้างประวัติการขาย'  => array('index'),
	'กำหนดเวลาสร้างประวัติการขาย',
);
$this->menu = array(
	array('label'=>'สร้างประวัติการขาย', 'url'=>array('index')),
	array('label'=>Yii::t('app', 'Stop Auto Create'), 'url'=>'#', 'linkOptions' => array('submit' => array('stop'), 'confirm'=>'กรุณายืนยัน')),
);
?>

<h3>กำหนดเวลาสร้างประวัติการขาย</h3>

<div class="form">

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'install-form',
	'enableAjaxValidation' => true,
));
?>

<?php echo $form->textFieldRow($model, 'day'); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Start')); ?>

<?php $this->endWidget(); ?>
</div><!-- form -->