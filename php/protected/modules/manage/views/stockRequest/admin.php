<?php

$this->breadcrumbs=array(
    $this->module->id => array('/'.$this->module->id),
	'สร้างใบส่งสินค้า' => array('/'.$this->module->id.'/deliver/'),
	'รายการใบเบิก',
);

$this->menu = array(
    array('label'=>Yii::t('app', 'สร้างใบเบิก'), 'url' => array('StockRequest/create')),
);

?>

<h3>รายการใบเบิก</h3>

<p>

<?php
$columns = array(
    array(
        'header'=>CHtml::encode('เลขที่ใบเบิก'),
        'name'=>'id',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ประเภท'),
        'name'=>'RequestType',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('Flag'),
        'name'=>'RequestFlag',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('วันที่เบิก'),
        'name'=>'RequestDate',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
   	array(
		'class' => 'bootstrap.widgets.TbButtonColumn',
		'template'=>'{view}{copy}',
		'buttons'=>array(
            'view' => array(
                'label'=>'รายละเอียดใบเบิก',
                'url'=>'Yii::app()->createUrl("/manage/stockRequest/view", array("id"=>$data["id"]))',
            ),
            'copy' => array(
                'label'=>'copy ใบเบิก',
                'imageUrl'=>Yii::app()->request->baseUrl.'/images/copy.png',
                'url'=>'Yii::app()->createUrl("/manage/stockRequest/copy", array("id"=>$data["id"]))',
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