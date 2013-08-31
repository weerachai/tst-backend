<?php
$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'ตรวจสต็อค/สร้างประวัติการขาย'
);

$this->menu=array(
	array('label'=>'Auto Create', 'url'=>array('auto')),
	array('label'=>Yii::t('app', 'Stop Auto Create'), 'url'=>'#', 'linkOptions' => array('submit' => array('stop'), 'confirm'=>'กรุณายืนยัน')),
);
?>
<h3>ตรวจสต็อค/สร้างประวัติการขาย</h3>
<div>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>
<?php echo GxHtml::submitButton(Yii::t('app', 'สร้างประวัติ')); ?>
<?php $this->endWidget(); ?>
</div>
