<?php
/* @var $this StartStockController */

$this->breadcrumbs=array(
    $this->module->id => array('/'.$this->module->id),
	'ตรวจสต็อค',
);
?>

<h3>ข้อมูลรายการสต็อคตั้งต้น</h3>

<?php 
$columns = array(
    array(
        'header'=>CHtml::encode('ชื่อหน่วยขาย'),
        'name'=>'SaleName',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('สิ้นค้า'),
        'name'=>'ProductName',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('จำนวน'),
        'name'=>'Qty',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('หน่วย'),
        'name'=>'Pack',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
	array(
		'class' => 'bootstrap.widgets.TbButtonColumn',
		'template'=>'{delete}',
		'buttons'=>array(
			'delete' => array(
	    		'label'=>'ยกเลิกความสัมพันธ์',
	        	'url'=>'Yii::app()->createUrl("/manage/startStock/delete", array("saleId"=>$data["id"],"productId"=>$data["productId"],"level"=>$data["Level"]))',
		    ),
		),
		'htmlOptions' => array('style'=>'white-space:nowrap'),
 	),
);

$this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'stock-check-grid',
    'filter'=>$filtersForm,
    'ajaxUpdate'=>false,
	'type' => 'striped bordered condensed',
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

<h3>เพิ่มรายการสต็อคตั้งต้น</h3>
<div>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'stock-form',
		'type'=>'horizontal',
		'enableAjaxValidation' => true,
	)); ?>

<fieldset>

<?php echo $form->dropDownListRow($model, 'SaleId', SaleUnit::model()->getAssigendOptions(), array(
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

<?php echo $form->dropDownListRow($model, 'GrpLevel1Id', StockCheckList::model()->getCheckGrpLevel1(''), array(
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

<?php echo $form->dropDownListRow($model, 'GrpLevel2Id',  StockCheckList::model()->getCheckGrpLevel2('',''), array(
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

<?php echo $form->dropDownListRow($model, 'GrpLevel3Id', StockCheckList::model()->getCheckGrpLevel3('','',''), array(
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

<?php echo $form->radioButtonListInlineRow($model, 'Type', array(
		'ขายได้',
		'แถมได้',
		'ทั้งหมด',
	)); ?>

<?php echo $form->dropDownListRow($model, 'ProductId', StockCheckList::model()->getCheckProduct('','','','')); ?>

<?php echo $form->dropDownListRow($model, 'Pack',
        array('1', '2', '3', '4', '5')); ?>
<?php echo $form->textFieldRow($model, 'Qty'); ?>

</fieldset>

<div class="form-actions">
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'เพิ่มรายการ')); ?>
</div>

<?php $this->endWidget(); ?>
</div>
