<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'stock-request-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'RequestNo'); ?>
		<?php echo $form->textField($model, 'RequestNo', array('readonly'=>true)); ?>
		<?php echo $form->error($model,'RequestNo'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->hiddenField($model, 'RequestType', array('readonly'=>true)); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'RequestFlag'); ?>
		<?php echo $form->dropDownList($model, 'RequestFlag', array('ต้นทริป'=>'ต้นทริป','ระหว่างทริป'=>'ระหว่างทริป')); ?>
		<?php echo $form->error($model,'RequestFlag'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'SaleId'); ?>
		<?php echo $form->dropDownList($model, 'SaleId', SaleUnit::model()->getStockSaleOptions(), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('/helper/getRequestId'),
//						'dataType'=>'json',
 		                'data'=>array('SaleId'=>'js:this.value'),
 		                'success'=>'function(data) {
                     		$("#'.CHtml::activeId($model, "RequestNo").'").val(data);
                		}',
					))); ?>
		<?php echo $form->error($model,'SaleId'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'RequestDate'); ?>
		<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'RequestDate',
			'value' => $model->RequestDate,
			'options' => array(
				'showButtonPanel' => true,
				'changeYear' => true,
				'dateFormat' => 'yy-mm-dd',
				),
			));
; ?>
		<?php echo $form->error($model,'RequestDate'); ?>
		</div><!-- row -->
		<label><?php //echo GxHtml::encode($model->getRelationLabel('requestDetails')); ?></label>
		<?php //echo $form->checkBoxList($model, 'requestDetails', GxHtml::encodeEx(GxHtml::listDataEx(RequestDetail::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', $buttons));
$this->endWidget();
?>
</div><!-- form -->