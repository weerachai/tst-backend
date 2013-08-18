<?php
$this->breadcrumbs=array(
	'Manage'=>array('index'),
);?>
<h1> Manage database backup files</h1>

<?php $this->renderPartial('_list', array(
	'dataProvider'=>$dataProvider,
	'enablePagination' => true,
    'pager' => array(
        'cssFile' => false,
        'header' => false,
        'firstPageLabel' => 'หน้าแรก',
        'prevPageLabel' => 'หน้าก่อน',
        'nextPageLabel' => 'หน้าถัดไป',
        'lastPageLabel' => 'หน้าสุดท้าย',
    ), 
));
?>
