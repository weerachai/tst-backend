<?php
$this->breadcrumbs=array(
    'ข้อมูล' => array('/data/'),
	'Backup และ Restore',
);?>
<h3> Manage database backup files</h3>

<?php $this->renderPartial('_list', array(
	'dataProvider'=>$dataProvider,
));
?>
