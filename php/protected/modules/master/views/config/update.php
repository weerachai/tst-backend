<?php

$this->breadcrumbs = array(
	'Master & Formula' => array('/master/'),
	'Settings' => array('index'),
	'แก้ไข',
);

$this->menu=array(
	array('label'=>'กลับ', 'url'=>array('index')),
);
?>

<h3>แก้ไขค่า Settings</h3>

<div class="form">

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'config-form',
	'type'=>'horizontal',
	'enableAjaxValidation' => true,
));
?>

	<fieldset>
	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model, 'DayToClear', array('maxlength' => 50)); ?>
	<?php echo $form->dropDownListRow($model, 'Vat', array('bill' => 'ท้ายบิล', 'sku' => 'รายสินค้า')); ?>
	<?php echo $form->dropDownListRow($model, 'OverStock', array('Y' => 'ได้', 'N' => 'ไม่ได้')); ?>
	<?php echo $form->textFieldRow($model, 'ExchangeDiff', array('maxlength' => 50)); ?>
	<?php echo $form->dropDownListRow($model, 'ExchangePaymentMethod', array('bill' => 'ส่ง Bill Collection', 'cash' => 'เก็บเงินสด')); ?>
    </fieldset>
 
    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Save')); ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
    </div>
<?php
$this->endWidget();
?>
</div><!-- form -->