<?php
$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'ตรวจสต็อค/สร้างประวัติการขาย'  => array('index'),
	'สำเร็จ',
);
$this->menu = array(
	array('label'=>'สร้างประวัติการขาย', 'url'=>array('index')),
	array('label'=>'Auto Create', 'url'=>array('auto')),
);
?>

<h3>Success</h3>

<p>
	<?php if(isset($error)) echo $error; else echo 'Done';?>
</p>

