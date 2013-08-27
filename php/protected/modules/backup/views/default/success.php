<?php
$this->breadcrumbs=array(
    'ข้อมูล' => array('/data/'),
	'Backup และ Restore' => array('index'),
	'สำเร็จ',
);?>

<h3>Success</h3>

<p>
	<?php if(isset($error)) echo $error; else echo 'Done';?>
</p>


