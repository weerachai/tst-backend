<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'Promotion',
);

$this->menu = array(
        array('label'=>'เพิ่มโปรโมชั่นรายสินค้า', 'url'=>array('create','type'=>'sku')),
        array('label'=>'เพิ่มโปรโมชั่นกลุ่มสินค้า', 'url'=>array('create','type'=>'group')),
        array('label'=>'เพิ่มโปรโมชั่นท้ายบิล', 'url'=>array('create','type'=>'bill')),
        array('label'=>'เพิ่มโปรโมชั่นสะสม', 'url'=>array('create','type'=>'accu')),
);
?>

<h3>โปรโมชั่น</h3>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'page-form',
    'enableAjaxValidation'=>true,
)); ?>
 
<b>เริ่มวันที่ : </b>
<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'from_date',  // name of post parameter
    'value'=>$from_date,  // value comes from cookie after submittion
     'options'=>array(
        'showAnim'=>'fold',
        'dateFormat'=>'yy-mm-dd',
    ),
    'htmlOptions'=>array(
        'style'=>'height:20px;'
    ),
));
?>
<b> ถึงวันที่ : </b>
<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'to_date',
    'value'=>$to_date,
     'options'=>array(
        'showAnim'=>'fold',
        'dateFormat'=>'yy-mm-dd',
 
    ),
    'htmlOptions'=>array(
        'style'=>'height:20px;'
    ),
));
?>

<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Go'));?>
<?php $this->endWidget(); ?>

<?php
$columns = array(
    array(
        'header'=>CHtml::encode('ชุดโปรโมชั่น'),
        'name'=>'PromotionGroup',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('รหัสโปรโมชั่น'),
        'name'=>'PromotionId',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('เริ่ม'),
        'name'=>'StartDate',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('สิ้นสุด'),
        'name'=>'EndDate',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ประเภท'),
        'name'=>'PromotionType',
        'type'=>'raw',
        'value'=>'Promotion::model()->getPromotionTypeName($data["PromotionType"]);',
        'filter'=>array(
            'sku' => 'รายสินค้า',
            'group' => 'คละสินค้า',
            'bill' => 'ท้ายบิล',
            'accu-all' => 'สะสมทั้งหมด',
            'accu-l1' => 'สะสมกลุ่มใหญ่',
            'accu-l2' => 'สะสมกลุ่มกลาง',
            'accu-l3' => 'สะสมกลุ่มย่อย',
            'accu-sku' => 'สะสมรายสินค้า',
        ),
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('รหัสสินค้า / กลุ่มสินค้า'),
        'name'=>'ProductOrGrpId',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ชื่อสินค้า / กลุ่มสินค้า'),
        'name'=>'ProductOrGrpName',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ซื้อขั้นต่ำ'),
        'type'=>'raw',
        'value'=>'Promotion::model()->getMinBuy($data["MinAmount"],$data["MinSku"],$data["MinQty"],$data["Pack"]);',
        'htmlOptions' => array('style'=>'white-space:nowrap;text-align:right;'),
    ),
    array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
        'template'=>'{view} {update} {copy} {delete}',
        'buttons'=>array(
            'view' => array(
                'label'=>'รายละเอียด',
                'url'=>'Yii::app()->createUrl("/master/promotion/view", array("id"=>$data["id"]))',
            ),
            'update' => array(
                'label'=>'แก้ไขข้อมูล',
                'url'=>'Yii::app()->createUrl("/master/promotion/update", array("id"=>$data["id"]))',
            ),
            'copy' => array(
                'label'=>'copy โปรโมชั่น',
                'imageUrl'=>Yii::app()->request->baseUrl.'/images/copy.png',
                'url'=>'Yii::app()->createUrl("/master/promotion/copy", array("id"=>$data["id"]))',
            ),
            'delete' => array(
                'label'=>'ลบข้อมูล',
                'url'=>'Yii::app()->createUrl("/master/promotion/delete", array("id"=>$data["id"]))',
            ),
        ),
        'htmlOptions' => array('style'=>'white-space:nowrap','width'=>'80px'),
    ),
);

$this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'data-grid',
    'dataProvider' => $dataProvider,
    'filter'=>$filtersForm,
    'ajaxUpdate'=>true,
    'type'=>'striped bordered condensed',
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

<h3>กลุ่มสินค้าจัดโปรโมชั่น</h3>

<?php
$columns2 = array(
    array(
        'header'=>CHtml::encode('รหัสกลุ่มสินค้า'),
        'name'=>'ProductGrpId',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('รหัสสินค้า'),
        'name'=>'ProductId',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ชื่อสินค้า'),
        'name'=>'ProductName',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
        'template'=>'{delete}',
        'buttons'=>array(
            'delete' => array(
                'label'=>'ลบข้อมูล',
                'url'=>'Yii::app()->createUrl("/master/promotion/deleteProductGroup", array("id"=>$data["id"],"productId"=>$data["ProductId"]))',
            ),
        ),
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
);

$this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'data2-grid',
    'dataProvider' => $dataProvider2,
    'filter'=>$filtersForm2,
    'ajaxUpdate'=>false,
    'type'=>'striped bordered condensed',
    'enablePagination' => true,
    'pager' => array(
        'cssFile' => false,
        'header' => false,
        'firstPageLabel' => 'หน้าแรก',
        'prevPageLabel' => 'หน้าก่อน',
        'nextPageLabel' => 'หน้าถัดไป',
        'lastPageLabel' => 'หน้าสุดท้าย',
    ),  
    'columns' => $columns2,
));
?>

<div>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'insert-form2',
    'type'=>'horizontal',
    'enableAjaxValidation' => true,
));
?>

    <fieldset>
    <?php echo $form->textFieldRow($model2, 'ProductGrpId', array('maxlength' => 50)); ?>
    <?php echo $form->dropDownListRow($model2, 'GrpLevel1Id', Product::model()->getGroupLevel1(), array(
                    'ajax' => array(
                        'type'=>'POST', //request type
                        'url'=>CController::createUrl('/helper/getProductOptions'),
                        'dataType'=>'json',
                        'data'=>array('GrpLevel1Id'=>'js:this.value'),
                        'success'=>'function(data) {
                            $("#'.CHtml::activeId($model2, "GrpLevel2Id").'").html(data.grp2);
                            $("#'.CHtml::activeId($model2, "GrpLevel3Id").'").html(data.grp3);
                            $("#'.CHtml::activeId($model2, "ProductId").'").html(data.pro);
                        }',
                    ),
                    'empty' => 'ทั้งหมด',
                    )); ?>

<?php echo $form->dropDownListRow($model2, 'GrpLevel2Id', Product::model()->getGroupLevel2(''), array(
                    'ajax' => array(
                        'type'=>'POST', //request type
                        'url'=>CController::createUrl('/helper/getProductOptions'),
                        'dataType'=>'json',
                        'data'=>array('GrpLevel1Id'=>'js:'.CHtml::activeId($model2,'GrpLevel1Id').'.value',
                            'GrpLevel2Id'=>'js:this.value'),
                        'success'=>'function(data) {
                            $("#'.CHtml::activeId($model2, "GrpLevel3Id").'").html(data.grp3);
                            $("#'.CHtml::activeId($model2, "ProductId").'").html(data.pro);
                        }',
                    ),
                    'empty' => 'ทั้งหมด',
                    )); ?>

<?php echo $form->dropDownListRow($model2, 'GrpLevel3Id', Product::model()->getGroupLevel3(''), array(
                    'ajax' => array(
                        'type'=>'POST', //request type
                        'url'=>CController::createUrl('/helper/getProductOptions'),
                        'dataType'=>'json',
                        'data'=>array('GrpLevel1Id'=>'js:'.CHtml::activeId($model2,'GrpLevel1Id').'.value',
                            'GrpLevel2Id'=>'js:'.CHtml::activeId($model2,'GrpLevel2Id').'.value',
                            'GrpLevel3Id'=>'js:this.value'),
                        'success'=>'function(data) {
                            $("#'.CHtml::activeId($model2, "ProductId").'").html(data.pro);
                        }',
                    ),
                    'empty' => 'ทั้งหมด',
                    )); ?>
    <?php echo $form->dropDownListRow($model2, 'ProductId', Product::model()->getOptions()); ?>
    </fieldset>
 
    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Insert')); ?>
   </div>
<?php
$this->endWidget();
?>
</div><!-- form -->

<h3>กลุ่มสินค้าแถม</h3>

<?php
$columns3 = array(
    array(
        'header'=>CHtml::encode('รหัสกลุ่มสินค้า'),
        'name'=>'FreeGrpId',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('รหัสสินค้า'),
        'name'=>'ProductId',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('ชื่อสินค้า'),
        'name'=>'ProductName',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'header'=>CHtml::encode('หน่วย'),
        'name'=>'FreePack',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
    array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
        'template'=>'{delete}',
        'buttons'=>array(
            'delete' => array(
                'label'=>'ลบข้อมูล',
                'url'=>'Yii::app()->createUrl("/master/promotion/deleteFreeGroup", array("id"=>$data["id"],"productId"=>$data["ProductId"]))',
            ),
        ),
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
);

$this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'data3-grid',
    'dataProvider' => $dataProvider3,
    'filter'=>$filtersForm3,
    'ajaxUpdate'=>false,
    'type'=>'striped bordered condensed',
    'enablePagination' => true,
    'pager' => array(
        'cssFile' => false,
        'header' => false,
        'firstPageLabel' => 'หน้าแรก',
        'prevPageLabel' => 'หน้าก่อน',
        'nextPageLabel' => 'หน้าถัดไป',
        'lastPageLabel' => 'หน้าสุดท้าย',
    ),  
    'columns' => $columns3,
));
?>

<div>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'insert-form3',
    'type'=>'horizontal',
    'enableAjaxValidation' => true,
));
?>

    <fieldset>
    <?php echo $form->textFieldRow($model3, 'FreeGrpId', array('maxlength' => 50)); ?>
    <?php echo $form->dropDownListRow($model3, 'GrpLevel1Id', Product::model()->getGroupLevel1(), array(
                    'ajax' => array(
                        'type'=>'POST', //request type
                        'url'=>CController::createUrl('/helper/getProductOptions'),
                        'dataType'=>'json',
                        'data'=>array('GrpLevel1Id'=>'js:this.value'),
                        'success'=>'function(data) {
                            $("#'.CHtml::activeId($model3, "GrpLevel2Id").'").html(data.grp2);
                            $("#'.CHtml::activeId($model3, "GrpLevel3Id").'").html(data.grp3);
                            $("#'.CHtml::activeId($model3, "ProductId").'").html(data.pro);
                            $("#'.CHtml::activeId($model3, "FreePack").'").html(data.pack);
                        }',
                    ),
                    'empty' => 'ทั้งหมด',
                    )); ?>

<?php echo $form->dropDownListRow($model3, 'GrpLevel2Id', Product::model()->getGroupLevel2(''), array(
                    'ajax' => array(
                        'type'=>'POST', //request type
                        'url'=>CController::createUrl('/helper/getProductOptions'),
                        'dataType'=>'json',
                        'data'=>array('GrpLevel1Id'=>'js:'.CHtml::activeId($model3,'GrpLevel1Id').'.value',
                            'GrpLevel2Id'=>'js:this.value'),
                        'success'=>'function(data) {
                            $("#'.CHtml::activeId($model3, "GrpLevel3Id").'").html(data.grp3);
                            $("#'.CHtml::activeId($model3, "ProductId").'").html(data.pro);
                            $("#'.CHtml::activeId($model3, "FreePack").'").html(data.pack);
                        }',
                    ),
                    'empty' => 'ทั้งหมด',
                    )); ?>

<?php echo $form->dropDownListRow($model3, 'GrpLevel3Id', Product::model()->getGroupLevel3(''), array(
                    'ajax' => array(
                        'type'=>'POST', //request type
                        'url'=>CController::createUrl('/helper/getProductOptions'),
                        'dataType'=>'json',
                        'data'=>array('GrpLevel1Id'=>'js:'.CHtml::activeId($model3,'GrpLevel1Id').'.value',
                            'GrpLevel2Id'=>'js:'.CHtml::activeId($model3,'GrpLevel2Id').'.value',
                            'GrpLevel3Id'=>'js:this.value'),
                        'success'=>'function(data) {
                            $("#'.CHtml::activeId($model3, "ProductId").'").html(data.pro);
                            $("#'.CHtml::activeId($model3, "FreePack").'").html(data.pack);
                        }',
                    ),
                    'empty' => 'ทั้งหมด',
                    )); ?>
    <?php echo $form->dropDownListRow($model3, 'ProductId', Product::model()->getOptions(), array(
                    'ajax' => array(
                        'type'=>'POST', //request type
                        'url'=>CController::createUrl('/helper/getProductOptions'),
                        'dataType'=>'json',
                        'data'=>array('GrpLevel1Id'=>'js:'.CHtml::activeId($model3,'GrpLevel1Id').'.value',
                            'GrpLevel2Id'=>'js:'.CHtml::activeId($model3,'GrpLevel2Id').'.value',
                            'GrpLevel3Id'=>'js:'.CHtml::activeId($model3,'GrpLevel3Id').'.value',
                            'ProductId'=>'js:this.value'),
                        'success'=>'function(data) {
                            $("#'.CHtml::activeId($model3, "FreePack").'").html(data.pack);
                        }',
                    ))); ?>    
    <?php echo $form->dropDownListRow($model3, 'FreePack', Product::model()->getPacks()); ?>
    </fieldset>
 
    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Insert')); ?>
   </div>
<?php
$this->endWidget();
?>
</div><!-- form -->