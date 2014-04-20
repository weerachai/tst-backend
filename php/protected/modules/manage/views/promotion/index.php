<?php

$this->breadcrumbs=array(
  'กำหนดความสัมพันธ์' => array('/manage'),
	'กำหนดโปรโมชั่น',
);
?>

<h3>ข้อมูลโปรโมชั่น</h3>

<?php 
$columns = array(
      array(
      'name'=>'SaleId',
      'header'=>'รหัสหน่วยขาย',
      'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      array(
      'name'=>'SaleName',
      'header'=>'ชื่อหน่วยขาย',
      'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      array(
      'name'=>'Province',
      'header'=>'จังหวัด',
      'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      array(
      'name'=>'District',
      'header'=>'อำเภอ',
      'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      array(
      'name'=>'SubDistrict',
      'header'=>'ตำบล',
      'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      array(
      'name'=>'PromotionSku',
      'header'=>'ชุดโปรโมชั่น<br>รายสินค้า',
      'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      array(
      'name'=>'PromotionGroup',
      'header'=>'ชุดโปรโมชั่น<br>กลุ่ม',
      'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      array(
      'name'=>'PromotionBill',
      'header'=>'ชุดโปรโมชั่น<br>ท้ายบิล',
      'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      array(
      'name'=>'PromotionAccu',
      'header'=>'ชุดโปรโมชั่น<br>สะสม',
      'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      array(
        'header'=>CHtml::encode('จำนวนร้านค้า'),
        'name'=>'Num',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
      array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template'=>'{view} {delete}',
            'buttons'=>array(
                'view' => array(
                  'label'=>'แสดงรายชื่อร้านค้า',
                  'url'=>'Yii::app()->createUrl("/manage/promotion/view", array("id"=>$data["SaleId"],"province"=>$data["Province"],"district"=>$data["District"],"subdistrict"=>$data["SubDistrict"]))',
                ),                  
                'delete' => array(
                  'label'=>'ยกเลิกโปรโมชั่น',
	        	      'url'=>'Yii::app()->createUrl("/manage/promotion/delete", array("id"=>$data["SaleId"],"province"=>$data["Province"],"district"=>$data["District"],"subdistrict"=>$data["SubDistrict"]))',
                ),
            ),
            'htmlOptions' => array('style'=>'white-space:nowrap'),
      ),
);

$this->widget('bootstrap.widgets.TbExtendedGridView', array(
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

<h3>กำหนดเขตการขายของร้านค้า</h3>
<div>
<?php $form = $this->beginWidget('CActiveForm'); ?>

<div class="row">
<?php echo CHtml::label('หน่วยขาย: ',  'SaleId'); ?>
<?php echo CHtml::dropDownList('SaleId',  null, SaleUnit::model()->getNoPromotionOptions(), array(
          'ajax' => array(
            'type'=>'POST', //request type
            'url'=>CController::createUrl('/helper/getNoPromotionLocations'),
            'dataType'=>'json',
                    'data'=>array('SaleId'=>'js:this.value'),
                    'success'=>'function(data) {
                        $("#Province").html(data.provinces);
                        $("#District").html(data.districts);
                        $("#SubDistrict").html(data.subdistricts);
                    }',
          ))); ?>

<?php echo CHtml::label('จังหวัด: ',  'Province'); ?>
<?php echo CHtml::dropDownList('Province',  null, Customer::model()->getNoPromotionProvinces(''), array(
          'ajax' => array(
            'type'=>'POST', //request type
            'url'=>CController::createUrl('/helper/getNoPromotionLocations'),
            'dataType'=>'json',
                    'data'=>array('SaleId'=>'js:SaleId.value',
                      'Province'=>'js:this.value'),
                    'success'=>'function(data) {
                        $("#District").html(data.districts);
                        $("#SubDistrict").html(data.subdistricts);
                    }',
          ))); ?>

<?php echo CHtml::label('อำเภอ: ',  'District'); ?>
<?php echo CHtml::dropDownList('District',  null, Customer::model()->getNoPromotionDistricts('',''), array(
          'ajax' => array(
            'type'=>'POST', //request type
            'url'=>CController::createUrl('/helper/getNoPromotionLocations'),
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
<?php echo CHtml::dropDownList('SubDistrict',  null, Customer::model()->getNoPromotionSubDistricts('','','')); ?>

<?php echo CHtml::label('โปรโมชั่นรายสินค้า: ',  'PromotionSku'); ?>
<?php echo CHtml::dropDownList('PromotionSku',  null, Promotion::model()->getPromotionOptions('sku'), array('empty' => '-')); ?>

<?php echo CHtml::label('โปรโมชั่นรายกลุ่ม: ',  'PromotionGroup'); ?>
<?php echo CHtml::dropDownList('PromotionGroup',  null, Promotion::model()->getPromotionOptions('group'), array('empty' => '-')); ?>

<?php echo CHtml::label('โปรโมชั่นรายท้ายบิล: ',  'PromotionBill'); ?>
<?php echo CHtml::dropDownList('PromotionBill',  null, Promotion::model()->getPromotionOptions('bill'), array('empty' => '-')); ?>

<?php echo CHtml::label('โปรโมชั่นรายสะสม: ',  'PromotionAccu'); ?>
<?php echo CHtml::dropDownList('PromotionAccu',  null, Promotion::model()->getPromotionOptions('accu'), array('empty' => '-')); ?>

<?php echo GxHtml::submitButton(Yii::t('app', 'กำหนดโปรโมชั่น')); ?>
</div><!-- row -->
<?php $this->endWidget(); ?>
</div>