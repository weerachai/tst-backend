<?php
/* @var $this CustomerController */

$this->breadcrumbs=array(
    $this->module->id => array('/'.$this->module->id),
	'ร้านค้า',
);
?>
<h1>ข้อมูลหน่วยขายและร้านค้า</h1>

<?php 
$columns = array(
    array(
        'header'=>CHtml::encode('รหัสหน่วยขาย'),
        'name'=>'SaleId',
    ),
    array(
        'header'=>CHtml::encode('ชื่อหน่วยขาย'),
        'name'=>'SaleName',
    ),
    array(
        'header'=>CHtml::encode('จังหวัด'),
        'name'=>'Province',
    ),
    array(
        'header'=>CHtml::encode('อำเภอ'),
        'name'=>'District',
    ),
    array(
        'header'=>CHtml::encode('ตำบล'),
        'name'=>'SubDistrict',
    ),
    array(
        'header'=>CHtml::encode('จำนวนร้านค้า'),
        'name'=>'Num',
    ),
	array(
		'class' => 'bootstrap.widgets.TbButtonColumn',
		'template'=>'{view}{delete}',
		'buttons'=>array(
			'view' => array(
	    		'label'=>'แสดงรายชื่อร้านค้า',
	        	'url'=>'Yii::app()->createUrl("view", array("id"=>$data["id"]))',
		    ),
			'delete' => array(
	    		'label'=>'ยกเลิกความสัมพันธ์',
	        	'url'=>'Yii::app()->createUrl("delete", array("id"=>$data["id"]))',
		    ),
		),
 	),
);

$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'id'=>'customer-grid',
    'filter'=>$filtersForm,
	'type' => 'striped bordered',
	'dataProvider' => $dataProvider,
	'template' => "{items}\n{extendedSummary}",
	'bulkActions' => array(
	'actionButtons' => array(
		array(
			'id' => 'delete',
			'buttonType' => 'button',
			'type' => 'primary',
			'size' => 'small',
			'label' => 'Testing Primary Bulk Actions',
			'click' => 'js:function(values){console.log(values);}'
			)
		),
		// if grid doesn't have a checkbox column type, it will attach
		// one and this configuration will be part of it
		'checkBoxColumnConfig' => array(
		    'name' => 'id'
		),
	),
	'columns' => $columns,
	'extendedSummary' => array(
		'title' => 'จำนวนร้านค้า',
		'columns' => array(
			'Num' => array('label'=>'จำนวนร้าน', 'class'=>'TbSumOperation')
		)
	),
	'extendedSummaryOptions' => array(
		'class' => 'well pull-right',
		'style' => 'width:300px'
	),
));

/*
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'customer-grid',
    'dataProvider'=>$dataProvider,
    'columns'=>$columns,
    'filter'=>$filtersForm,
    'selectableRows'=>2,
));

$this->widget('ext.widgets.bmenu.XBatchMenu', array(
    'formId'=>'customer-form',
    'checkBoxId'=>'customer-id',
    'ajaxUpdate'=>'customer-grid', // if you want to update grid by ajax
    'emptyText'=>Yii::t('ui','Please check items you would like to perform this action on!'),
    'confirm'=>Yii::t('ui','Are you sure to perform this action on checked items?'),
    'items'=>array(
        array('label'=>Yii::t('ui','Make selected persons 1 year younger'),'url'=>array('updateYears','op'=>'more')),
        array('label'=>Yii::t('ui','Make selected persons 1 year older'),'url'=>array('updateYears','op'=>'less')),
    ),
    'htmlOptions'=>array('class'=>'actionBar'),
));
*/
 ?>
