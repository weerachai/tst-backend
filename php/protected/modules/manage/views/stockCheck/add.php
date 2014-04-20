<?php
/* @var $this StockCheckController */

$this->breadcrumbs=array(
    'กำหนดความสัมพันธ์' => array('/manage'),
	'ตรวจสต็อค' => array('/manage/stockCheck'),
	'เพิ่มรายการสินค้าตรวจสต็อค'
);


$this->menu = array(
	array('label'=>Yii::t('app', 'ข้อมูลรายการตรวจสต็อค'), 'url' => array('index')),
);

?>

<h3>เพิ่มรายการสินค้าตรวจสต็อค</h3>
<div>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'search-form',
    'enableAjaxValidation'=>true,
)); ?>

<div class="row">
<?php echo CHtml::label('หน่วยขาย: ',  'SaleId'); ?>
<?php echo CHtml::dropDownList('SaleId',  $SaleId, SaleUnit::model()->getOptions(), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getCheckOptions'),
						'dataType'=>'json',
 		                'data'=>array('SaleId'=>'js:this.value'),
 		                'success'=>'function(data) {
                    		$("#GrpLevel1Id").html(data.grp1);
							$("#GrpLevel2Id").html(data.grp2);
							$("#GrpLevel3Id").html(data.grp3);
                		}',
					))); ?>

<?php echo CHtml::label('กลุ่มใหญ่: ',  'GrpLevel1Id'); ?>
<?php echo CHtml::dropDownList('GrpLevel1Id', $GrpLevel1Id, StockCheckList::model()->getCheckGrpLevel1($SaleId), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getCheckOptions'),
						'dataType'=>'json',
 		                'data'=>array('SaleId'=>'js:SaleId.value',
 		                	'GrpLevel1Id'=>'js:this.value'),
 		                'success'=>'function(data) {
							$("#GrpLevel2Id").html(data.grp2);
							$("#GrpLevel3Id").html(data.grp3);
                		}',
					))); ?>

<?php echo CHtml::label('กลุ่มกลาง: ',  'GrpLevel2Id'); ?>
<?php echo CHtml::dropDownList('GrpLevel2Id',  $GrpLevel2Id, StockCheckList::model()->getCheckGrpLevel2($SaleId,$GrpLevel1Id), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getCheckOptions'),
						'dataType'=>'json',
 		                'data'=>array('SaleId'=>'js:SaleId.value',
 		                	'GrpLevel1Id'=>'js:GrpLevel1Id.value',
 		                	'GrpLevel2Id'=>'js:this.value'),
 		                'success'=>'function(data) {
							$("#GrpLevel3Id").html(data.grp3);
                		}',
					))); ?>

<?php echo CHtml::label('กลุ่มย่อย: ',  'GrpLevel3Id'); ?>
<?php echo CHtml::dropDownList('GrpLevel3Id',  $GrpLevel3Id, StockCheckList::model()->getCheckGrpLevel3($SaleId,$GrpLevel1Id,$GrpLevel2Id)); ?>

<?php echo GxHtml::submitButton(Yii::t('app', 'ค้นหาสินค้า')); ?>
</div><!-- row -->
<?php $this->endWidget(); ?>
</div>

<?php $form=$this->beginWidget('CActiveForm'); ?>
<?php echo CHtml::hiddenField('SaleId', $SaleId); ?>
<?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id' => 'data-grid',
    'ajaxUpdate'=>true,
	'type'=>'striped bordered condensed',
	'template' => '{items}',
	'dataProvider' => $dataProvider,
	'enablePagination' => false,
    'pager' => array(
        'cssFile' => false,
        'header' => false,
        'firstPageLabel' => 'หน้าแรก',
        'prevPageLabel' => 'หน้าก่อน',
        'nextPageLabel' => 'หน้าถัดไป',
        'lastPageLabel' => 'หน้าสุดท้าย',
    ),  
	'columns'=>array(
		array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 2,
            'checkBoxHtmlOptions' => array(
                'name' => 'ids[]',
            ),
        ),
    	array(
        	'header'=>CHtml::encode('รหัสสินค้า'),
        	'name'=>'ProductId',
        	'htmlOptions' => array('style'=>'white-space:nowrap'),
   	 	),
    	array(
        	'header'=>CHtml::encode('ชื้อสินค้า'),
        	'name'=>'ProductName',
        	'htmlOptions' => array('style'=>'white-space:nowrap'),
    	),
	),
));

echo GxHtml::submitButton(Yii::t('app', 'เพิ่มรายการ')); ?>
</div><!-- row -->
<?php $this->endWidget(); ?>
</div>

