<?php

$this->breadcrumbs=array(
    $this->module->id => array('/'.$this->module->id),
	'สร้างใบส่งสินค้า' => array('/'.$this->module->id.'/deliver/'),
	'รายละเอียดใบเบิก'
);

$this->menu = array(
	array('label'=>'รายการใบเบิก', 'url' => array('admin')),
);
?>

<h3><?php echo 'รายละเอียดใบเบิก เลขที่: ' . $id; ?></h3>

<?php 

$columns = array(
    array(
        'header'=>CHtml::encode('รหัสสินค้า'),
        'name'=>'id',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ชื่อสินค้า'),
        'name'=>'ProductName',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('จำนวน'),
        'type'=>'raw',
		'value'=>'Product::model()->formatQty($data,"QtyLevel");',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
   	array(
		'class' => 'bootstrap.widgets.TbButtonColumn',
		'template'=>'{update}{delete}',
		'buttons'=>array(
			'update' => array(
	    		'label'=>'แสดงรายชื่อร้านค้า',
	        	'url'=>'Yii::app()->createUrl("/manage/stockRequest/update", array("id"=>$data["RequestNo"],"productId"=>$data["id"]))',
		    ),
			'delete' => array(
	    		'label'=>'แสดงรายชื่อร้านค้า',
	        	'url'=>'Yii::app()->createUrl("/manage/stockRequest/delete", array("id"=>$data["RequestNo"],"productId"=>$data["id"]))',
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

<h3 id="title">เพิ่มรายการสินค้า</h3>
<div>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'stock-form',
		'type'=>'horizontal',
		'enableAjaxValidation' => true,
	)); ?>

<fieldset>

<?php echo $form->dropDownListRow($model, 'GrpLevel1Id', RequestDetail::model()->getGrpLevel1($model->RequestNo), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getRequestOptions'),
						'dataType'=>'json',
 		                'data'=>array('RequestNo'=>$model->RequestNo,
 		                	'GrpLevel1Id'=>'js:this.value'),
 		                'success'=>'function(data) {
                    		$("#'.CHtml::activeId($model, "GrpLevel2Id").'").html(data.grp2);
                    		$("#'.CHtml::activeId($model, "GrpLevel3Id").'").html(data.grp3);
                    		$("#'.CHtml::activeId($model, "ProductId").'").html(data.pro);
                    		$("#'.CHtml::activeId($model, "QtyLevel1").'").attr("disabled",data.l1);
                    		$("#'.CHtml::activeId($model, "QtyLevel2").'").attr("disabled",data.l2);
                    		$("#'.CHtml::activeId($model, "QtyLevel3").'").attr("disabled",data.l3);
                    		$("#'.CHtml::activeId($model, "QtyLevel4").'").attr("disabled",data.l4);
                            $("#PackLevel1").html(data.p1);
                            $("#PackLevel2").html(data.p2);
                            $("#PackLevel3").html(data.p3);
                            $("#PackLevel4").html(data.p4);
               		}',
					))); ?>

<?php echo $form->dropDownListRow($model, 'GrpLevel2Id',  RequestDetail::model()->getGrpLevel2($model->RequestNo,''), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getRequestOptions'),
						'dataType'=>'json',
 		                'data'=>array('RequestNo'=>$model->RequestNo,
 		                	'GrpLevel1Id'=>'js:'.CHtml::activeId($model,'GrpLevel1Id').'.value',
 		                	'GrpLevel2Id'=>'js:this.value'),
 		                'success'=>'function(data) {
                    		$("#'.CHtml::activeId($model, "GrpLevel3Id").'").html(data.grp3);
                    		$("#'.CHtml::activeId($model, "ProductId").'").html(data.pro);
                    		$("#'.CHtml::activeId($model, "QtyLevel1").'").attr("disabled",data.l1);
                    		$("#'.CHtml::activeId($model, "QtyLevel2").'").attr("disabled",data.l2);
                    		$("#'.CHtml::activeId($model, "QtyLevel3").'").attr("disabled",data.l3);
                    		$("#'.CHtml::activeId($model, "QtyLevel4").'").attr("disabled",data.l4);
                            $("#PackLevel1").html(data.p1);
                            $("#PackLevel2").html(data.p2);
                            $("#PackLevel3").html(data.p3);
                            $("#PackLevel4").html(data.p4);
              		}',
					))); ?>

<?php echo $form->dropDownListRow($model, 'GrpLevel3Id', RequestDetail::model()->getGrpLevel3($model->RequestNo,'',''), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getRequestOptions'),
						'dataType'=>'json',
 		                'data'=>array('RequestNo'=>$model->RequestNo,
 		                	'GrpLevel1Id'=>'js:'.CHtml::activeId($model,'GrpLevel1Id').'.value',
 		                	'GrpLevel2Id'=>'js:'.CHtml::activeId($model,'GrpLevel2Id').'.value',
 		                	'GrpLevel3Id'=>'js:this.value'),
 		                'success'=>'function(data) {
                    		$("#'.CHtml::activeId($model, "ProductId").'").html(data.pro);
                     		$("#'.CHtml::activeId($model, "QtyLevel1").'").attr("disabled",data.l1);
                    		$("#'.CHtml::activeId($model, "QtyLevel2").'").attr("disabled",data.l2);
                    		$("#'.CHtml::activeId($model, "QtyLevel3").'").attr("disabled",data.l3);
                    		$("#'.CHtml::activeId($model, "QtyLevel4").'").attr("disabled",data.l4);
                            $("#PackLevel1").html(data.p1);
                            $("#PackLevel2").html(data.p2);
                            $("#PackLevel3").html(data.p3);
                            $("#PackLevel4").html(data.p4);
             		}',
					))); ?>

<?php echo $form->textFieldRow($model, 'ProductIdName', array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getRequestOptions'),
						'dataType'=>'json',
 		                'data'=>array('RequestNo'=>$model->RequestNo,
 		                	'GrpLevel1Id'=>'js:'.CHtml::activeId($model,'GrpLevel1Id').'.value',
 		                	'GrpLevel2Id'=>'js:'.CHtml::activeId($model,'GrpLevel2Id').'.value',
 		                	'GrpLevel3Id'=>'js:'.CHtml::activeId($model,'GrpLevel3Id').'.value',
 		                	'ProductIdName'=>'js:this.value'),
 		                'success'=>'function(data) {
                     		$("#'.CHtml::activeId($model, "ProductId").'").html(data.pro);
                    		$("#'.CHtml::activeId($model, "QtyLevel1").'").attr("disabled",data.l1);
                    		$("#'.CHtml::activeId($model, "QtyLevel2").'").attr("disabled",data.l2);
                    		$("#'.CHtml::activeId($model, "QtyLevel3").'").attr("disabled",data.l3);
                    		$("#'.CHtml::activeId($model, "QtyLevel4").'").attr("disabled",data.l4);
                            $("#PackLevel1").html(data.p1);
                            $("#PackLevel2").html(data.p2);
                            $("#PackLevel3").html(data.p3);
                            $("#PackLevel4").html(data.p4);
                		}',
					),
					'append'=>' ค้น',
					)); ?>

<?php echo $form->dropDownListRow($model, 'ProductId', RequestDetail::model()->getProduct($model->RequestNo,'','','',''), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getRequestOptions'),
						'dataType'=>'json',
 		                'data'=>array('RequestNo'=>$model->RequestNo,
 		                	'GrpLevel1Id'=>'js:'.CHtml::activeId($model,'GrpLevel1Id').'.value',
 		                	'GrpLevel2Id'=>'js:'.CHtml::activeId($model,'GrpLevel2Id').'.value',
 		                	'GrpLevel3Id'=>'js:'.CHtml::activeId($model,'GrpLevel3Id').'.value',
 		                	'ProductId'=>'js:this.value'),
 		                'success'=>'function(data) {
                    		$("#'.CHtml::activeId($model, "QtyLevel1").'").attr("disabled",data.l1);
                    		$("#'.CHtml::activeId($model, "QtyLevel2").'").attr("disabled",data.l2);
                    		$("#'.CHtml::activeId($model, "QtyLevel3").'").attr("disabled",data.l3);
                    		$("#'.CHtml::activeId($model, "QtyLevel4").'").attr("disabled",data.l4);
                            $("#PackLevel1").html(data.p1);
                            $("#PackLevel2").html(data.p2);
                            $("#PackLevel3").html(data.p3);
                            $("#PackLevel4").html(data.p4);
                		}',
					))); ?>

<?php echo $form->textFieldRow($model, 'QtyLevel1', array('disabled'=>empty($model->product->PackLevel1),'append'=>' <div id="PackLevel1">'.$model->product->PackLevel1.'</div>')); ?>
<?php echo $form->textFieldRow($model, 'QtyLevel2', array('disabled'=>empty($model->product->PackLevel2),'append'=>' <div id="PackLevel2">'.$model->product->PackLevel2.'</div>')); ?>
<?php echo $form->textFieldRow($model, 'QtyLevel3', array('disabled'=>empty($model->product->PackLevel3),'append'=>' <div id="PackLevel3">'.$model->product->PackLevel3.'</div>')); ?>
<?php echo $form->textFieldRow($model, 'QtyLevel4', array('disabled'=>empty($model->product->PackLevel4),'append'=>' <div id="PackLevel4">'.$model->product->PackLevel4.'</div>')); ?>
<?php echo $form->hiddenField($model, 'RequestNo'); ?>
<?php echo $form->hiddenField($model, 'PriceLevel1'); ?>
<?php echo $form->hiddenField($model, 'PriceLevel2'); ?>
<?php echo $form->hiddenField($model, 'PriceLevel3'); ?>
<?php echo $form->hiddenField($model, 'PriceLevel4'); ?>

</fieldset>

<div class="form-actions">
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'เพิ่มรายการ')); ?>
</div>

<?php $this->endWidget(); ?>
</div>