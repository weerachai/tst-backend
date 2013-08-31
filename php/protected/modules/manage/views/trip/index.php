<?php
/* @var $this TripController */

$this->breadcrumbs=array(
    'กำหนดความสัมพันธ์' => array('/manage'),
	'ทริป',
);
?>

<h3>ข้อมูลทริป</h3>

<?php 
$columns = array(
    array(
        'header'=>CHtml::encode('รหัสอุปกรณ์'),
        'name'=>'DeviceId',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ชื่อพนักงานขาย'),
        'name'=>'Name',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('วันออกทริป'),
        'name'=>'Trip',
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
	        	'url'=>'Yii::app()->createUrl("/manage/trip/view", array("saleId"=>$data["SaleId"],"trip"=>$data["Trip"],"province"=>$data["Province"],"district"=>$data["District"],"subdistrict"=>$data["SubDistrict"]))',
		    ),
			'delete' => array(
	    		'label'=>'ยกเลิกความสัมพันธ์',
	        	'url'=>'Yii::app()->createUrl("/manage/trip/delete", array("saleId"=>$data["SaleId"],"trip"=>$data["Trip"],"province"=>$data["Province"],"district"=>$data["District"],"subdistrict"=>$data["SubDistrict"]))',
		    ),
		),
		'htmlOptions' => array('style'=>'white-space:nowrap'),
 	),
);

$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'id'=>'trip-grid',
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

<h3>กำหนดทริป</h3>
<div>
<?php $form = $this->beginWidget('CActiveForm'); ?>

<div class="row">
<?php echo CHtml::label('พนักกงานขาย: ',  'SaleId'); ?>
<?php echo CHtml::dropDownList('SaleId',  null, Employee::model()->getAssignedOptions(), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getSaleLocations'),
						'dataType'=>'json',
 		                'data'=>array('SaleId'=>'js:this.value',
 		                	'Trip'=>'js:Trip.value'),
  		                'success'=>'function(data) {
                    		$("#Province").html(data.provinces);
                    		$("#District").html(data.districts);
							$("#SubDistrict").html(data.subdistricts);
                		}',
					))); ?>

<?php echo CHtml::label('ประเภททริป: ',  'Type'); ?>
<?php echo CHtml::dropDownList('Type',  null, array('m'=>'แบบเดือน','w'=>'แบบสัปดาห์'), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getTrips'),
						'dataType'=>'json',
 		                'data'=>array('Type'=>'js:this.value'),
 		                'success'=>'function(data) {
                    		$("#Trip").html(data.trips);
                		}',
					))); ?>

<?php echo CHtml::label('วันออกทริป: ',  'Trip'); ?>
<?php echo CHtml::dropDownList('Trip',  null, Trip::model()->getOptions('m')); ?>

<?php echo CHtml::label('จังหวัด: ',  'Province'); ?>
<?php echo CHtml::dropDownList('Province',  null, Customer::model()->getSaleProvinces(''), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getSaleLocations'),
						'dataType'=>'json',
 		                'data'=>array('SaleId'=>'js:SaleId.value',
 		                	'Province'=>'js:this.value'),
 		                'success'=>'function(data) {
                    		$("#District").html(data.districts);
							$("#SubDistrict").html(data.subdistricts);
                		}',
					))); ?>

<?php echo CHtml::label('อำเภอ: ',  'District'); ?>
<?php echo CHtml::dropDownList('District',  null, Customer::model()->getSaleDistricts('',''), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getSaleLocations'),
						'dataType'=>'json',
 		                'data'=>array('SaleId'=>'js:SaleId.value',
 		                	'Province'=>'js:Province.value',
 		                	'District'=>'js:this.value'),
 		                'success'=>'function(data) {
							$("#SubDistrict").html(data.subdistricts);
                		}',
					),
					)); ?>

<?php echo CHtml::label('ตำบล: ',  'SubDistrict'); ?>
<?php echo CHtml::dropDownList('SubDistrict',  null, Customer::model()->getSaleSubDistricts('','','')); ?>

<?php echo GxHtml::submitButton(Yii::t('app', 'กำหนดวันออกทริป')); ?>
</div><!-- row -->
<?php $this->endWidget(); ?>
</div>
