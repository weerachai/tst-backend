<?php
$this->breadcrumbs=array(
    'ข้อมูล' => array('/data/'),
	'นำข้อมูลออก' => array('index'),
	'สำเร็จ',
);
$this->menu = array(
	array('label'=>Yii::t('app', 'นำข้อมูลออก'), 'url' => array('index')),
	array('label'=>Yii::t('app', 'Auto Export'), 'url' => array('auto')),
	array('label'=>Yii::t('app', 'Stop Auto Export'), 'url'=>'#', 'linkOptions' => array('submit' => array('stop'), 'confirm'=>'กรุณายืนยัน')),
);
?>

<h3>Success</h3>

<p>
	<?php if(isset($error)) echo $error; else echo 'Done';?>
</p>

