<?php
/* @var $this CustomerController */

$this->breadcrumbs=array(
    'กำหนดความสัมพันธ์' => array('/manage'),
	'ร้านค้า',
);
?>

<h3>ข้อมูลหน่วยขายและร้านค้า</h3>

<?php 
$columns = array(
    array(
        'header'=>CHtml::encode('รหัสหน่วยขาย'),
        'name'=>'SaleId',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ชื่อหน่วยขาย'),
        'name'=>'SaleName',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('จังหวัด'),
        'name'=>'Province',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('อำเภอ'),
        'name'=>'District',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ตำบล'),
        'name'=>'SubDistrict',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('จำนวนร้านค้า'),
        'name'=>'Num',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
	array(
		'class' => 'bootstrap.widgets.TbButtonColumn',
		'template'=>'{view}{delete}',
		'buttons'=>array(
			'view' => array(
	    		'label'=>'แสดงรายชื่อร้านค้า',
	        	'url'=>'Yii::app()->createUrl("/manage/customer/view", array("province"=>$data["Province"],"district"=>$data["District"],"subdistrict"=>$data["SubDistrict"]))',
		    ),
			'delete' => array(
	    		'label'=>'ยกเลิกความสัมพันธ์',
	        	'url'=>'Yii::app()->createUrl("/manage/customer/delete", array("province"=>$data["Province"],"district"=>$data["District"],"subdistrict"=>$data["SubDistrict"]))',
		    ),
		),
		'htmlOptions' => array('style'=>'white-space:nowrap'),
 	),
);

$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'id'=>'customer-grid',
    'filter'=>$filtersForm,
    'ajaxUpdate'=>false,
	'type' => 'striped bordered',
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
//	'template' => "{items}",
	'columns' => $columns,
	/*
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
	*/
));

?>

<h3>กำหนดเขตการขายของร้านค้า</h3>
<div>
<?php $form = $this->beginWidget('CActiveForm'); ?>

<div class="row">
<?php echo CHtml::label('หน่วยขาย: ',  'SaleId'); ?>
<?php echo CHtml::dropDownList('SaleId',  null, SaleUnit::model()->getUnassigendOptions()); ?>

<?php echo CHtml::label('จังหวัด: ',  'Province'); ?>
<?php echo CHtml::dropDownList('Province',  null, Customer::model()->getAvailableProvinces(), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getAvailableLocations'),
						'dataType'=>'json',
 		                'data'=>array('Province'=>'js:this.value'),
 		                'success'=>'function(data) {
                    		$("#District").html(data.districts);
							$("#SubDistrict").html(data.subdistricts);
                		}',
					))); ?>

<?php echo CHtml::label('อำเภอ: ',  'District'); ?>
<?php echo CHtml::dropDownList('District',  null, Customer::model()->getAvailableDistricts(''), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getAvailableLocations'),
						'dataType'=>'json',
 		                'data'=>array('Province'=>'js:Province.value',
 		                	'District'=>'js:this.value'),
 		                'success'=>'function(data) {
							$("#SubDistrict").html(data.subdistricts);
                		}',
					),
					)); ?>

<?php echo CHtml::label('ตำบล: ',  'SubDistrict'); ?>
<?php echo CHtml::dropDownList('SubDistrict',  null, Customer::model()->getAvailableSubDistricts('','')); ?>

<?php echo GxHtml::submitButton(Yii::t('app', 'กำหนดเขตการขาย')); ?>
</div><!-- row -->
<?php $this->endWidget(); ?>
</div>
