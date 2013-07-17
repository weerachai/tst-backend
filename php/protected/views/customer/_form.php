<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'customer-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'CustomerId'); ?>
		<?php echo $form->textField($model, 'CustomerId', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'CustomerId'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'SaleId'); ?>
		<?php echo $form->dropDownList($model, 'SaleId',
			SaleUnit::model()->getOptions(),
			array('empty' => '(ระบุหน่วยขาย)')); ?>
		<?php echo $form->error($model,'SaleId'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Title'); ?>
		<?php echo $form->dropDownList($model, 'Title', CustomerTitle::model()->getOptions()); ?>
		<?php echo $form->error($model,'Title'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'CustomerName'); ?>
		<?php echo $form->textField($model, 'CustomerName', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'CustomerName'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Type'); ?>
		<?php echo $form->dropDownList($model, 'Type', array('CR' => 'เครดิต', 'CH' => 'เงินสด')); ?>
		<?php echo $form->error($model,'Type'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Trip1'); ?>
		<?php echo $form->dropDownList($model, 'Trip1',
			Trip::model()->getOptions(),
			array('empty' => '(ระบุทริปที่ 1)')); ?>
		<?php echo $form->error($model,'Trip1'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Trip2'); ?>
		<?php echo $form->dropDownList($model, 'Trip2',
			Trip::model()->getOptions(),
			array('empty' => '(ระบุทริปที่ 2)')); ?>
		<?php echo $form->error($model,'Trip2'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Trip3'); ?>
		<?php echo $form->dropDownList($model, 'Trip3',
			Trip::model()->getOptions(),
			array('empty' => '(ระบุทริปที่ 3)')); ?>
		<?php echo $form->error($model,'Trip3'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Province'); ?>
		<?php echo $form->dropDownList($model,'Province', $model->getProvinces(), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('helper/getLocations'),
						'dataType'=>'json',
 		                'data'=>array('Province'=>'js:this.value'),
 		                'success'=>'function(data) {
                    		$("#'.CHtml::activeId($model, "District").'").html(data.districts);
							$("#'.CHtml::activeId($model, "SubDistrict").'").html(data.subdistricts);
							$("#'.CHtml::activeId($model, "ZipCode").'").html(data.zipcodes);
                		}',
					))); ?>
		<?php echo $form->error($model,'Province'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'District'); ?>
		<?php echo $form->dropDownList($model, 'District', $model->getDistricts(), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('helper/getLocations'),
						'dataType'=>'json',
 		                'data'=>array('Province'=>'js:'.CHtml::activeId($model,'Province').'.value',
 		                	'District'=>'js:this.value'),
 		                'success'=>'function(data) {
							$("#'.CHtml::activeId($model, "SubDistrict").'").html(data.subdistricts);
							$("#'.CHtml::activeId($model, "ZipCode").'").html(data.zipcodes);
                		}',
					))); ?>
		<?php echo $form->error($model,'District'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'SubDistrict'); ?>
		<?php echo $form->dropDownList($model, 'SubDistrict', $model->getSubDistricts(), array(
					'ajax' => array(
						'type'=>'POST', //request type
						'url'=>CController::createUrl('helper/getLocations'),
						'dataType'=>'json',
 		                'data'=>array('Province'=>'js:'.CHtml::activeId($model,'Province').'.value',
 		                	'District'=>'js:'.CHtml::activeId($model,'District').'.value',
 		                	'SubDistrict'=>'js:this.value'),
 		                'success'=>'function(data) {
							$("#'.CHtml::activeId($model, "ZipCode").'").html(data.zipcodes);
                		}',
					))); ?>
		<?php echo $form->error($model,'SubDistrict'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'ZipCode'); ?>
		<?php echo $form->dropDownList($model, 'ZipCode', $model->getZipCodes()); ?>
		<?php echo $form->error($model,'ZipCode'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'AddrNo'); ?>
		<?php echo $form->textField($model, 'AddrNo', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'AddrNo'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Moo'); ?>
		<?php echo $form->textField($model, 'Moo', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'Moo'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Village'); ?>
		<?php echo $form->textField($model, 'Village', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'Village'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Soi'); ?>
		<?php echo $form->textField($model, 'Soi', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'Soi'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Road'); ?>
		<?php echo $form->textField($model, 'Road', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'Road'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Phone'); ?>
		<?php echo $form->textField($model, 'Phone', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'Phone'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'ContactPerson'); ?>
		<?php echo $form->textField($model, 'ContactPerson', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'ContactPerson'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'CreditTerm'); ?>
		<?php echo $form->textField($model, 'CreditTerm'); ?>
		<?php echo $form->error($model,'CreditTerm'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'CreditLimit'); ?>
		<?php echo $form->textField($model, 'CreditLimit', array('maxlength' => 20)); ?>
		<?php echo $form->error($model,'CreditLimit'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'OverCreditType'); ?>
		<?php echo $form->dropDownList($model, 'OverCreditType', array('N' => 'ไม่ได้', 'P' => 'ขอรหัส', 'W' => 'แจ้งเตือน')); ?>
		<?php echo $form->error($model,'OverCreditType'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'Due'); ?>
		<?php echo $form->textField($model, 'Due', array('maxlength' => 20)); ?>
		<?php echo $form->error($model,'Due'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'PoseCheck'); ?>
		<?php echo $form->textField($model, 'PoseCheck', array('maxlength' => 20)); ?>
		<?php echo $form->error($model,'PoseCheck'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'ReturnCheck'); ?>
		<?php echo $form->textField($model, 'ReturnCheck', array('maxlength' => 20)); ?>
		<?php echo $form->error($model,'ReturnCheck'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'NewFlag'); ?>
		<?php echo $form->dropDownList($model, 'NewFlag', array('Y'=>'Yes','N'=>'No')); ?>
		<?php echo $form->error($model,'NewFlag'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'DeleteFlag'); ?>
		<?php echo $form->dropDownList($model, 'DeleteFlag', array('N'=>'No','Y'=>'Yes')); ?>
		<?php echo $form->error($model,'DeleteFlag'); ?>
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