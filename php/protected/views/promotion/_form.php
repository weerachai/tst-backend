<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'promotion-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'PromotionGroup'); ?>
		<?php echo $form->textField($model, 'PromotionGroup', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'PromotionGroup'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'PromotionId'); ?>
		<?php echo $form->textField($model, 'PromotionId', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'PromotionId'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'StartDate'); ?>
		<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'StartDate',
			'value' => $model->StartDate,
			'options' => array(
				'showButtonPanel' => true,
				'changeYear' => true,
				'dateFormat' => 'yy-mm-dd',
				),
			));
; ?>
		<?php echo $form->error($model,'StartDate'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'EndDate'); ?>
		<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'EndDate',
			'value' => $model->EndDate,
			'options' => array(
				'showButtonPanel' => true,
				'changeYear' => true,
				'dateFormat' => 'yy-mm-dd',
				),
			));
; ?>
		<?php echo $form->error($model,'EndDate'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'PromotionType'); ?>
		<?php echo $form->dropDownList($model, 'PromotionType', $model->getPromotionTypes(), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('helper/getProductsOrGroups'),
						'update'=>'#'.CHtml::activeId($model,'ProductOrGrpId'),
 		                'data'=>array('PromotionType'=>'js:this.value'),
					))); ?>
		<?php echo $form->error($model,'PromotionType'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'ProductOrGrpId'); ?>
		<?php echo $form->dropDownList($model, 'ProductOrGrpId', $model->getProductsOrGroups()); ?>
		<?php echo $form->error($model,'ProductOrGrpId'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'MinAmount'); ?>
		<?php echo $form->textField($model, 'MinAmount'); ?>
		<?php echo $form->error($model,'MinAmount'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'MinSku'); ?>
		<?php echo $form->textField($model, 'MinSku'); ?>
		<?php echo $form->error($model,'MinSku'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'MinQty'); ?>
		<?php echo $form->textField($model, 'MinQty'); ?>
		<?php echo $form->error($model,'MinQty'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Pack'); ?>
		<?php echo $form->dropDownList($model, 'Pack',
			Product::model()->getPacks(),
			array('empty' => '-')); ?>
		<?php echo $form->error($model,'Pack'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'DiscBaht'); ?>
		<?php echo $form->textField($model, 'DiscBaht'); ?>
		<?php echo $form->error($model,'DiscBaht'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'DiscPerAmount'); ?>
		<?php echo $form->textField($model, 'DiscPerAmount'); ?>
		<?php echo $form->error($model,'DiscPerAmount'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'DiscPerQty'); ?>
		<?php echo $form->textField($model, 'DiscPerQty'); ?>
		<?php echo $form->error($model,'DiscPerQty'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'DiscPer1'); ?>
		<?php echo $form->textField($model, 'DiscPer1'); ?>
		<?php echo $form->error($model,'DiscPer1'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'DiscPer2'); ?>
		<?php echo $form->textField($model, 'DiscPer2'); ?>
		<?php echo $form->error($model,'DiscPer2'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'DiscPer3'); ?>
		<?php echo $form->textField($model, 'DiscPer3'); ?>
		<?php echo $form->error($model,'DiscPer3'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'FreeType'); ?>
		<?php echo $form->dropDownList($model, 'FreeType', $model->getFreeTypes(), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('helper/getFreeProductsOrGroups'),
						'update'=>'#'.CHtml::activeId($model,'FreeProductOrGrpId'),
 		                'data'=>array('FreeType'=>'js:this.value'),
					),
					'empty' => '-'
					)); ?>
		<?php echo $form->error($model,'FreeType'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'FreeProductOrGrpId'); ?>
		<?php echo $form->dropDownList($model, 'FreeProductOrGrpId', $model->getFreeProductsOrGroups()); ?>
		<?php echo $form->error($model,'FreeProductOrGrpId'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'FreeQty'); ?>
		<?php echo $form->textField($model, 'FreeQty'); ?>
		<?php echo $form->error($model,'FreeQty'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'FreePack'); ?>
		<?php echo $form->dropDownList($model, 'FreePack',
			Product::model()->getPacks(),
			array('empty' => '-')); ?>
		<?php echo $form->error($model,'FreePack'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'FreePerAmount'); ?>
		<?php echo $form->textField($model, 'FreePerAmount'); ?>
		<?php echo $form->error($model,'FreePerAmount'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'FreePerQty'); ?>
		<?php echo $form->textField($model, 'FreePerQty'); ?>
		<?php echo $form->error($model,'FreePerQty'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'FreeBaht'); ?>
		<?php echo $form->textField($model, 'FreeBaht'); ?>
		<?php echo $form->error($model,'FreeBaht'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Formula'); ?>
		<?php echo $form->dropDownList($model, 'Formula', $model->getFormulas()); ?>
		<?php echo $form->error($model,'Formula'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'UpdateAt'); ?>
		<?php echo $form->textField($model, 'UpdateAt'); ?>
		<?php echo $form->error($model,'UpdateAt'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->