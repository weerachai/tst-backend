<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'sale-area-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'AreaId'); ?>
		<?php echo $form->textField($model, 'AreaId', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'AreaId'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'AreaName'); ?>
		<?php echo $form->textField($model, 'AreaName', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'AreaName'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Province'); ?>
		<?php echo $form->dropDownList($model,'Province',$model->getProvinces(), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('helper/getLocations'),
						'dataType'=>'json',
 		                'data'=>array('Province'=>'js:this.value'),
 		                'success'=>'function(data) {
                    		$("#'.CHtml::activeId($model, "District").'").html(data.districts);
							$("#'.CHtml::activeId($model, "SubDistrict").'").html(data.subdistricts);
                		}',
					))); ?>
		<?php echo $form->error($model,'Province'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'District'); ?>
		<?php echo $form->dropDownList($model,'District', $model->getDistricts(), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('helper/getLocations'),
						'dataType'=>'json',
 		                'data'=>array('Province'=>'js:'.CHtml::activeId($model,'Province').'.value',
 		                	'District'=>'js:this.value'),
  		                'success'=>'function(data) {
							$("#'.CHtml::activeId($model, "SubDistrict").'").html(data.subdistricts);
                		}',
					))); ?>
		<?php echo $form->error($model,'District'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'SubDistrict'); ?>
		<?php echo $form->dropDownList($model, 'SubDistrict', $model->getSubDistricts()); ?>
		<?php echo $form->error($model,'SubDistrict'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'SupervisorId'); ?>
		<?php echo $form->dropDownList($model,'SupervisorId', 
			Employee::model()->getOptions(),
			array('empty' => '(ระบุหัวหน้า)')); ?>
		<?php echo $form->error($model,'SupervisorId'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->