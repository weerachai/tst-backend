<?php
/* @var $this StockCheckController */

$this->breadcrumbs=array(
    'กำหนดความสัมพันธ์' => array('/manage'),
	'ตรวจสต็อค',
);
?>

<h3>ข้อมูลรายการตรวจสต็อค</h3>

<?php 
$columns = array(
    array(
        'header'=>CHtml::encode('ชื่อหน่วยขาย'),
        'name'=>'SaleName',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('กลุ่มใหญ่'),
        'name'=>'GrpLevel1Name',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('กลุ่มกลาง'),
        'name'=>'GrpLevel2Name',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('กลุ่มย่อย'),
        'name'=>'GrpLevel3Name',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('สิ้นค้า'),
        'name'=>'ProductName',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
	array(
		'class' => 'bootstrap.widgets.TbButtonColumn',
		'template'=>'{delete}',
		'buttons'=>array(
			'delete' => array(
	    		'label'=>'ยกเลิกความสัมพันธ์',
	        	'url'=>'Yii::app()->createUrl("/manage/stockCheck/delete", array("saleId"=>$data["id"],"grpLevel1Id"=>$data["GrpLevel1Id"],"grpLevel2Id"=>$data["GrpLevel2Id"],"grpLevel3Id"=>$data["GrpLevel3Id"],"productId"=>$data["ProductId"]))',
		    ),
		),
		'htmlOptions' => array('style'=>'white-space:nowrap'),
 	),
);

$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'id'=>'stock-check-grid',
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

<h3>เพิ่มรายการตรวจสต็อค</h3>
<div>
<?php $form = $this->beginWidget('CActiveForm'); ?>

<div class="row">
<?php echo CHtml::label('หน่วยขาย: ',  'SaleId'); ?>
<?php echo CHtml::dropDownList('SaleId',  null, SaleUnit::model()->getAssigendOptions(), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getCheckOptions'),
						'dataType'=>'json',
 		                'data'=>array('SaleId'=>'js:this.value'),
 		                'success'=>'function(data) {
                    		$("#GrpLevel1Id").html(data.grp1);
							$("#GrpLevel2Id").html(data.grp2);
							$("#GrpLevel3Id").html(data.grp3);
							$("#ProductId").html(data.pro);
                		}',
					))); ?>

<?php echo CHtml::label('กลุ่มใหญ่: ',  'GrpLevel1Id'); ?>
<?php echo CHtml::dropDownList('GrpLevel1Id',  null, StockCheckList::model()->getCheckGrpLevel1(''), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getCheckOptions'),
						'dataType'=>'json',
 		                'data'=>array('SaleId'=>'js:SaleId.value',
 		                	'GrpLevel1Id'=>'js:this.value'),
 		                'success'=>'function(data) {
							$("#GrpLevel2Id").html(data.grp2);
							$("#GrpLevel3Id").html(data.grp3);
							$("#ProductId").html(data.pro);
                		}',
					))); ?>

<?php echo CHtml::label('กลุ่มกลาง: ',  'GrpLevel2Id'); ?>
<?php echo CHtml::dropDownList('GrpLevel2Id',  null, StockCheckList::model()->getCheckGrpLevel2('',''), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getCheckOptions'),
						'dataType'=>'json',
 		                'data'=>array('SaleId'=>'js:SaleId.value',
 		                	'GrpLevel1Id'=>'js:GrpLevel1Id.value',
 		                	'GrpLevel2Id'=>'js:this.value'),
 		                'success'=>'function(data) {
							$("#GrpLevel3Id").html(data.grp3);
							$("#ProductId").html(data.pro);
                		}',
					))); ?>

<?php echo CHtml::label('กลุ่มย่อย: ',  'GrpLevel3Id'); ?>
<?php echo CHtml::dropDownList('GrpLevel3Id',  null, StockCheckList::model()->getCheckGrpLevel3('','',''), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getCheckOptions'),
						'dataType'=>'json',
 		                'data'=>array('SaleId'=>'js:SaleId.value',
 		                	'GrpLevel1Id'=>'js:GrpLevel1Id.value',
 		                	'GrpLevel2Id'=>'js:GrpLevel2Id.value',
 		                	'GrpLevel3Id'=>'js:this.value'),
 		                'success'=>'function(data) {
							$("#ProductId").html(data.pro);
                		}',
					))); ?>

<?php echo CHtml::label('สิ้นค้า: ',  'ProductId'); ?>
<?php echo CHtml::dropDownList('ProductId',  null, StockCheckList::model()->getCheckProduct('','','','')); ?>

<?php echo GxHtml::submitButton(Yii::t('app', 'เพิ่มรายการ')); ?>
</div><!-- row -->
<?php $this->endWidget(); ?>
</div>
