<?php

$this->breadcrumbs=array(
    'กำหนดความสัมพันธ์' => array('/manage'),
	'สร้างใบส่งสินค้า' => array('/manage/deliver/'),
	'รายการ IR',
);

$this->menu = array(
    array('label'=>Yii::t('app', 'สร้าง IR'), 'url' => array('StockIR/create')),
);

?>

<h3>รายการ IR</h3>

<p>

<?php
$columns = array(
    array(
        'header'=>CHtml::encode('เลขที่ IR'),
        'name'=>'id',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('วันที่ IR'),
        'name'=>'IRDate',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('จำนวนใบเบิก'),
        'name'=>'Num',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
   	array(
		'class' => 'bootstrap.widgets.TbButtonColumn',
		'template'=>'{view} {delete} {confirm}',
		'buttons'=>array(
            'view' => array(
                'label'=>'รายการใบเบิก',
                'url'=>'Yii::app()->createUrl("/manage/stockIR/view", array("id"=>$data["id"]))',
            ),
            'delete' => array(
                'label'=>'ยกเลิก IR',
                'url'=>'Yii::app()->createUrl("/manage/stockIR/delete", array("id"=>$data["id"]))',
                'visible'=>'empty($data["UpdateAt"])',
            ),
            'confirm' => array(
                'label'=>'ยืนยัน',
                'imageUrl'=>Yii::app()->request->baseUrl.'/images/confirm.png',
                'url'=>'Yii::app()->createUrl("/manage/stockIR/confirm", array("id"=>$data["id"]))',
                'visible'=>'empty($data["UpdateAt"])',
            ),
		),
		'htmlOptions' => array('style'=>'white-space:nowrap'),
 	),
);

$this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'data-grid',
    'filter'=>$filtersForm,
    'ajaxUpdate'=>false,
	'type'=>'striped bordered condensed',
	'dataProvider' => $dataProvider,
	'enablePagination' => true,
    'pager' => array(
        'cssFile' => false,
        'header' => false,
        'firstPageLabel' => 'หน้าแรก',
        'prevPageLabel' => 'หน้าก่อน',
        'nextPageLabel' => 'หน้าถัดไป',
        'lastPageLabel' => 'หน้าสุดท้าย',
    ),  
	'columns' => $columns,
));

?>
