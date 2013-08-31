<?php
/* @var $this StartStockController */

$this->breadcrumbs=array(
    'กำหนดความสัมพันธ์' => array('/manage'),
	'สต็อคตั้งต้น',
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
	        	'url'=>'Yii::app()->createUrl("/manage/startStock/delete", array("saleId"=>$data["id"],"productId"=>$data["ProductId"],"level"=>$data["Level"]))',
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
						'url'=>CController::createUrl('/helper/getStockStartOptions'),
						'dataType'=>'json',
 		                'data'=>array('SaleId'=>'js:this.value'),
 		                'success'=>'function(data) {
                    		$("#'.CHtml::activeId($model, "GrpLevel1Id").'").html(data.grp1);
                    		$("#'.CHtml::activeId($model, "GrpLevel2Id").'").html(data.grp2);
                    		$("#'.CHtml::activeId($model, "GrpLevel3Id").'").html(data.grp3);
                    		$("#'.CHtml::activeId($model, "Type").'").html(data.type);
                    		$("#'.CHtml::activeId($model, "ProductId").'").html(data.pro);
                     		$("#'.CHtml::activeId($model, "Pack").'").html(data.pack);
                		}',
					))); ?>

<?php echo $form->dropDownListRow($model, 'GrpLevel1Id', StockStartList::model()->getGrpLevel1(''), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getStockStartOptions'),
						'dataType'=>'json',
 		                'data'=>array('SaleId'=>'js:'.CHtml::activeId($model,'SaleId').'.value',
 		                	'GrpLevel1Id'=>'js:this.value'),
 		                'success'=>'function(data) {
                    		$("#'.CHtml::activeId($model, "GrpLevel2Id").'").html(data.grp2);
                    		$("#'.CHtml::activeId($model, "GrpLevel3Id").'").html(data.grp3);
                    		$("#'.CHtml::activeId($model, "Type").'").html(data.type);
                    		$("#'.CHtml::activeId($model, "ProductId").'").html(data.pro);
                     		$("#'.CHtml::activeId($model, "Pack").'").html(data.pack);
               		}',
					))); ?>

<?php echo $form->dropDownListRow($model, 'GrpLevel2Id',  StockStartList::model()->getGrpLevel2('',''), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getStockStartOptions'),
						'dataType'=>'json',
 		                'data'=>array('SaleId'=>'js:'.CHtml::activeId($model,'SaleId').'.value',
 		                	'GrpLevel1Id'=>'js:'.CHtml::activeId($model,'GrpLevel1Id').'.value',
 		                	'GrpLevel2Id'=>'js:this.value'),
 		                'success'=>'function(data) {
                    		$("#'.CHtml::activeId($model, "GrpLevel3Id").'").html(data.grp3);
                    		$("#'.CHtml::activeId($model, "Type").'").html(data.type);
                    		$("#'.CHtml::activeId($model, "ProductId").'").html(data.pro);
                     		$("#'.CHtml::activeId($model, "Pack").'").html(data.pack);
               		}',
					))); ?>

<?php echo $form->dropDownListRow($model, 'GrpLevel3Id', StockStartList::model()->getGrpLevel3('','',''), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getStockStartOptions'),
						'dataType'=>'json',
 		                'data'=>array('SaleId'=>'js:'.CHtml::activeId($model,'SaleId').'.value',
 		                	'GrpLevel1Id'=>'js:'.CHtml::activeId($model,'GrpLevel1Id').'.value',
 		                	'GrpLevel2Id'=>'js:'.CHtml::activeId($model,'GrpLevel2Id').'.value',
 		                	'GrpLevel3Id'=>'js:this.value'),
 		                'success'=>'function(data) {
                    		$("#'.CHtml::activeId($model, "Type").'").html(data.type);
                    		$("#'.CHtml::activeId($model, "ProductId").'").html(data.pro);
                      		$("#'.CHtml::activeId($model, "Pack").'").html(data.pack);
               		}',
					))); ?>

<?php echo $form->dropDownListRow($model, 'Type', StockStartList::model()->getType(), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getStockStartOptions'),
						'dataType'=>'json',
 		                'data'=>array('SaleId'=>'js:'.CHtml::activeId($model,'SaleId').'.value',
 		                	'GrpLevel1Id'=>'js:'.CHtml::activeId($model,'GrpLevel1Id').'.value',
 		                	'GrpLevel2Id'=>'js:'.CHtml::activeId($model,'GrpLevel2Id').'.value',
 		                	'GrpLevel3Id'=>'js:'.CHtml::activeId($model,'GrpLevel3Id').'.value',
 		                	'Type'=>'js:this.value'),
 		                'success'=>'function(data) {
                    		$("#'.CHtml::activeId($model, "ProductId").'").html(data.pro);
                     		$("#'.CHtml::activeId($model, "Pack").'").html(data.pack);
                		}',
					))); ?>

<?php echo $form->dropDownListRow($model, 'ProductId', StockStartList::model()->getProduct('','','','','a'), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getStockStartOptions'),
						'dataType'=>'json',
 		                'data'=>array('SaleId'=>'js:'.CHtml::activeId($model,'SaleId').'.value',
 		                	'GrpLevel1Id'=>'js:'.CHtml::activeId($model,'GrpLevel1Id').'.value',
 		                	'GrpLevel2Id'=>'js:'.CHtml::activeId($model,'GrpLevel2Id').'.value',
 		                	'GrpLevel3Id'=>'js:'.CHtml::activeId($model,'GrpLevel3Id').'.value',
 		                	'Type'=>'js:'.CHtml::activeId($model,'Type').'.value',
 		                	'ProductId'=>'js:this.value'),
 		                'success'=>'function(data) {
                     		$("#'.CHtml::activeId($model, "Pack").'").html(data.pack);
                		}',
					))); ?>

<?php echo $form->dropDownListRow($model, 'Pack', StockStartList::model()->getPack('')); ?>

<?php echo $form->textFieldRow($model, 'Qty'); ?>

</fieldset>

<div class="form-actions">
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'เพิ่มรายการ')); ?>
</div>

<?php $this->endWidget(); ?>
</div>
