<div class="form">

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'promotion-form',
	'type'=>'horizontal',
	'enableAjaxValidation' => true,
));
?>

    <fieldset>
	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model, 'PromotionGroup', array('maxlength' => 255)); ?>
	<?php echo $form->textFieldRow($model, 'PromotionId', array('maxlength' => 255)); ?>
	<?php echo $form->datepickerRow($model, 'StartDate',
        array('prepend'=>'<i class="icon-calendar"></i>',
        'options'=>array('format' => 'yyyy-mm-dd'))); ?>
	<?php echo $form->datepickerRow($model, 'EndDate',
        array('prepend'=>'<i class="icon-calendar"></i>',
        'options'=>array('format' => 'yyyy-mm-dd'))); ?>
	<?php echo $form->dropDownListRow($model, 'Formula', $model->getFormulas()); ?>
	<?php if ($type == 'accu')
			echo $form->dropDownListRow($model, 'PromotionType', $model->getPromotionTypes($type), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getProductsOrGroups'),
						'dataType'=>'json',
 		                'data'=>array('PromotionType'=>'js:this.value'),
 		                'success'=>'function(data) {
                    		$("#'.CHtml::activeId($model,'ProductOrGrpId').'").html(data.ProductOrGrpId);
                		}',
					))); ?>
	<?php if ($type != 'bill')
			echo $form->dropDownListRow($model, 'ProductOrGrpId', $model->getProductsOrGroups()); ?>
	
	<div class="well well-small">ซื้อขั้นต่ำ:</div>
	<?php echo $form->textFieldRow($model, 'MinAmount', array('append'=>' บาท',
					'disabled'=>($model->MinSku > 0 || $model->MinQty > 0),
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/toggleDisabled'),
						'dataType'=>'json',
 		                'data'=>array('name'=>'MinAmount',
 		                	'MinAmount'=>'js:this.value',
 		                	'DiscBaht'=>'js:'.CHtml::activeId($model, "DiscBaht").'.value',
  		                	'FreeQty'=>'js:'.CHtml::activeId($model, "FreeQty").'.value',
 		                	'FreeBaht'=>'js:'.CHtml::activeId($model, "FreeBaht").'.value',
 		                ),
 		                'success'=>'function(data) {
                     	$("#'.CHtml::activeId($model, "MinSku").'").attr("disabled",data.l1);
                     	$("#'.CHtml::activeId($model, "MinQty").'").attr("disabled",data.l1);
                      	$("#'.CHtml::activeId($model, "Pack").'").attr("disabled",data.l1);
                      	$("#'.CHtml::activeId($model, "DiscPerAmount").'").attr("disabled",data.l2);
                      	$("#'.CHtml::activeId($model, "FreePerAmount").'").attr("disabled",data.l3);
                      	$("#'.CHtml::activeId($model, "DiscPerQty").'").val(0);
                      	$("#'.CHtml::activeId($model, "FreePerQty").'").val(0);
               		}',
					))); ?>
	<?php echo $form->textFieldRow($model, 'MinSku', array('append'=>' sku',
					'disabled'=>($model->MinAmount > 0 || $model->MinQty > 0),
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/toggleDisabled'),
						'dataType'=>'json',
 		                'data'=>array('name'=>'MinSku',
 		                	'MinSku'=>'js:this.value',
 		                ),
 		                'success'=>'function(data) {
                     	$("#'.CHtml::activeId($model, "MinAmount").'").attr("disabled",data.l1);
                     	$("#'.CHtml::activeId($model, "MinQty").'").attr("disabled",data.l1);
                     	$("#'.CHtml::activeId($model, "Pack").'").attr("disabled",data.l1);
                      	$("#'.CHtml::activeId($model, "DiscPerQty").'").val(0);
                      	$("#'.CHtml::activeId($model, "FreePerQty").'").val(0);
                      	$("#'.CHtml::activeId($model, "DiscPerAmount").'").val(0);
                      	$("#'.CHtml::activeId($model, "FreePerAmount").'").val(0);
                 		}',
					))); ?>
	<?php echo $form->textFieldRow($model, 'MinQty', array('append'=>$form->dropDownList($model, 'Pack', Product::model()->getPacks(), array('empty' => '-',
					'disabled'=>($model->MinAmount > 0 || $model->MinSku > 0),
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/updatePack'),
						'dataType'=>'json',
 		                'data'=>array('value'=>'js:this.value'),
 		                'success'=>'function(data) {
                     	$("#DiscPerQtyPack").html(data.pack);
                     	$("#FreePerQtyPack").html(data.pack);
               			}',
					))),
					'disabled'=>($model->MinAmount > 0 || $model->MinSku > 0),
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/toggleDisabled'),
						'dataType'=>'json',
 		                'data'=>array('name'=>'MinQty',
 		                	'MinQty'=>'js:this.value',
 		                	'DiscBaht'=>'js:'.CHtml::activeId($model, "DiscBaht").'.value',
  		                	'FreeQty'=>'js:'.CHtml::activeId($model, "FreeQty").'.value',
 		                	'FreeBaht'=>'js:'.CHtml::activeId($model, "FreeBaht").'.value',
 		                ),
 		                'success'=>'function(data) {
                     	$("#'.CHtml::activeId($model, "MinAmount").'").attr("disabled",data.l1);
                     	$("#'.CHtml::activeId($model, "MinSku").'").attr("disabled",data.l1);
                      	$("#'.CHtml::activeId($model, "DiscPerQty").'").attr("disabled",data.l2);
                      	$("#'.CHtml::activeId($model, "FreePerQty").'").attr("disabled",data.l3);
                      	$("#'.CHtml::activeId($model, "DiscPerAmount").'").val(0);
                      	$("#'.CHtml::activeId($model, "FreePerAmount").'").val(0);
  	            		}',
					))); ?>
	
	<div class="well well-small">ส่วนลด:</div>
	<?php echo $form->textFieldRow($model, 'DiscBaht', array('append'=>' บาท',
					'disabled'=>($model->DiscPer1 > 0),
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/toggleDisabled'),
						'dataType'=>'json',
 		                'data'=>array('name'=>'DiscBaht',
 		                	'DiscBaht'=>'js:this.value',
 		                	'MinAmount'=>'js:'.CHtml::activeId($model, "MinAmount").'.value',
  		                	'MinQty'=>'js:'.CHtml::activeId($model, "MinQty").'.value',
 		                	'DiscPerAmount'=>'js:'.CHtml::activeId($model, "DiscPerAmount").'.value',
  		                	'DiscPerQty'=>'js:'.CHtml::activeId($model, "DiscPerQty").'.value',
 		                ),
 		                'success'=>'function(data) {
                     	$("#'.CHtml::activeId($model, "DiscPerAmount").'").attr("disabled",data.l1);
                     	$("#'.CHtml::activeId($model, "DiscPerAmount").'").val(data.v1);
                     	$("#'.CHtml::activeId($model, "DiscPerQty").'").attr("disabled",data.l2);
                     	$("#'.CHtml::activeId($model, "DiscPerQty").'").val(data.v2);
                      	$("#'.CHtml::activeId($model, "DiscPer1").'").attr("disabled",data.l3);
  	            		}',
					))); ?>
	<?php echo $form->textFieldRow($model, 'DiscPerAmount', array('append'=>' บาท',
					'disabled'=>($model->MinAmount == 0 || $model->DiscBaht == 0),
					)); ?>
	<?php echo $form->textFieldRow($model, 'DiscPerQty', array('append'=>' <div id="DiscPerQtyPack">'.$model->Pack.'</div>',
					'disabled'=>($model->MinQty == 0 || $model->DiscBaht == 0),
					)); ?>
	<?php echo $form->textFieldRow($model, 'DiscPer1', array('append'=>' %',
					'disabled'=>($model->DiscBaht > 0),
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/toggleDisabled'),
						'dataType'=>'json',
 		                'data'=>array('name'=>'DiscPer1',
 		                	'DiscPer1'=>'js:this.value',
 		                	'DiscPer2'=>'js:'.CHtml::activeId($model, "DiscPer2").'.value',
  		                	'DiscPer3'=>'js:'.CHtml::activeId($model, "DiscPer3").'.value',
 		                ),
 		                'success'=>'function(data) {
                     	$("#'.CHtml::activeId($model, "DiscBaht").'").attr("disabled",data.l1);
                     	$("#'.CHtml::activeId($model, "DiscPer2").'").attr("disabled",data.l2);
                     	$("#'.CHtml::activeId($model, "DiscPer2").'").val(data.v1);
                     	$("#'.CHtml::activeId($model, "DiscPer3").'").attr("disabled",data.l3);
                     	$("#'.CHtml::activeId($model, "DiscPer3").'").val(data.v2);
              			}',
					))); ?>
	<?php if ($type == 'sku' || $type == 'group')
			echo $form->textFieldRow($model, 'DiscPer2', array('append'=>' %',
					'disabled'=>($model->DiscPer1 == 0),
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/toggleDisabled'),
						'dataType'=>'json',
 		                'data'=>array('name'=>'DiscPer2',
 		                	'DiscPer2'=>'js:this.value',
  		                	'DiscPer3'=>'js:'.CHtml::activeId($model, "DiscPer3").'.value',
 		                ),
 		                'success'=>'function(data) {
                     	$("#'.CHtml::activeId($model, "DiscPer3").'").attr("disabled",data.l1);
                     	$("#'.CHtml::activeId($model, "DiscPer3").'").val(data.v1);
                		}',
					)));
		  else 
		  	echo $form->hiddenField($model, 'DiscPer2');
	?>
	<?php if ($type == 'sku' || $type == 'group')
			echo $form->textFieldRow($model, 'DiscPer3', array('append'=>' %',
					'disabled'=>($model->DiscPer2 == 0),
					));
		  else 
		  	echo $form->hiddenField($model, 'DiscPer3');
	?>
	<div class="well well-small">ของแถม:</div>
	<?php echo $form->dropDownListRow($model, 'FreeType', $model->getFreeTypes(), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getFreeProductsOrGroups'),
						'dataType'=>'json',
 		                'data'=>array('FreeType'=>'js:this.value',
  		                	'FreeQty'=>'js:'.CHtml::activeId($model, "FreeQty").'.value',
  		                	'FreeBaht'=>'js:'.CHtml::activeId($model, "FreeBaht").'.value',
  		                	'MinAmount'=>'js:'.CHtml::activeId($model, "MinAmount").'.value',
  		                	'MinQty'=>'js:'.CHtml::activeId($model, "MinQty").'.value',
 		                	'FreePerAmount'=>'js:'.CHtml::activeId($model, "FreePerAmount").'.value',
  		                	'FreePerQty'=>'js:'.CHtml::activeId($model, "FreePerQty").'.value',
 		                ),
 		                'success'=>'function(data) {
                    	$("#'.CHtml::activeId($model,'FreeProductOrGrpId').'").html(data.FreeProductOrGrpId);
                     	$("#'.CHtml::activeId($model, "FreeQty").'").attr("disabled",data.l1);
                     	$("#'.CHtml::activeId($model, "FreePack").'").attr("disabled",data.l1);
                     	$("#'.CHtml::activeId($model, "FreeQty").'").val(data.v1);
                     	$("#'.CHtml::activeId($model, "FreeBaht").'").attr("disabled",data.l2);
                     	$("#'.CHtml::activeId($model, "FreeBaht").'").val(data.v2);
                     	$("#'.CHtml::activeId($model, "FreePerAmount").'").attr("disabled",data.l3);
                     	$("#'.CHtml::activeId($model, "FreePerAmount").'").val(data.v3);
                     	$("#'.CHtml::activeId($model, "FreePerQty").'").attr("disabled",data.l4);
                     	$("#'.CHtml::activeId($model, "FreePerQty").'").val(data.v4);
	               		}',
					),
					'empty' => '-'
					)); ?>
	<?php echo $form->dropDownListRow($model, 'FreeProductOrGrpId', $model->getFreeProductsOrGroups()); ?>
	<?php if ($type == 'sku' || $type == 'group')
			echo $form->textFieldRow($model, 'FreeQty', array('append'=>$form->dropDownList($model, 'FreePack', Product::model()->getPacks(), array('empty' => '-',
					'disabled'=>(empty($model->FreeType) || $model->FreeBaht > 0),
					)),
					'disabled'=>(empty($model->FreeType) || $model->FreeBaht > 0),
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/toggleDisabled'),
						'dataType'=>'json',
 		                'data'=>array('name'=>'FreeQty',
 		                	'FreeQty'=>'js:this.value',
 		                	'MinAmount'=>'js:'.CHtml::activeId($model, "MinAmount").'.value',
  		                	'MinQty'=>'js:'.CHtml::activeId($model, "MinQty").'.value',
 		                	'FreePerAmount'=>'js:'.CHtml::activeId($model, "FreePerAmount").'.value',
  		                	'FreePerQty'=>'js:'.CHtml::activeId($model, "FreePerQty").'.value',
 		                ),
 		                'success'=>'function(data) {
                     	$("#'.CHtml::activeId($model, "FreePerAmount").'").attr("disabled",data.l1);
                     	$("#'.CHtml::activeId($model, "FreePerAmount").'").val(data.v1);
                     	$("#'.CHtml::activeId($model, "FreePerQty").'").attr("disabled",data.l2);
                     	$("#'.CHtml::activeId($model, "FreePerQty").'").val(data.v2);
                      	$("#'.CHtml::activeId($model, "FreeBaht").'").attr("disabled",data.l3);
                		}',
					)));
		  else 
		  	echo $form->hiddenField($model, 'FreeQty');
	?>
	<?php if ($type == 'bill' || $type == 'accu')
			echo $form->textFieldRow($model, 'FreeBaht', array('append'=>' บาท',
					'disabled'=>(empty($model->FreeType) || $model->FreeQty > 0),
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/toggleDisabled'),
						'dataType'=>'json',
 		                'data'=>array('name'=>'FreeBaht',
 		                	'FreeBaht'=>'js:this.value',
 		                	'MinAmount'=>'js:'.CHtml::activeId($model, "MinAmount").'.value',
  		                	'MinQty'=>'js:'.CHtml::activeId($model, "MinQty").'.value',
 		                	'FreePerAmount'=>'js:'.CHtml::activeId($model, "FreePerAmount").'.value',
  		                	'FreePerQty'=>'js:'.CHtml::activeId($model, "FreePerQty").'.value',
 		                ),
 		                'success'=>'function(data) {
                     	$("#'.CHtml::activeId($model, "FreePerAmount").'").attr("disabled",data.l1);
                     	$("#'.CHtml::activeId($model, "FreePerAmount").'").val(data.v1);
                     	$("#'.CHtml::activeId($model, "FreePerQty").'").attr("disabled",data.l2);
                     	$("#'.CHtml::activeId($model, "FreePerQty").'").val(data.v2);
                     	$("#'.CHtml::activeId($model, "FreeQty").'").attr("disabled",data.l3);
                     	$("#'.CHtml::activeId($model, "FreePack").'").attr("disabled",data.l3);
                		}',
					)));
		  else 
		  	echo $form->hiddenField($model, 'FreeBaht');
	?>
	<?php echo $form->textFieldRow($model, 'FreePerAmount', array('append'=>' บาท',
					'disabled'=>($model->MinAmount == 0 || ($model->FreeQty == 0 && $model->FreeBaht == 0)),
					)); ?>
	<?php echo $form->textFieldRow($model, 'FreePerQty', array('append'=>' <div id="FreePerQtyPack">'.$model->Pack.'</div>',
					'disabled'=>($model->MinQty == 0 || ($model->FreeQty == 0 && $model->FreeBaht == 0)),
					)); ?>


    </fieldset>
 
    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Save')); ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
    </div>

<?php
$this->endWidget();
?>
</div><!-- form -->