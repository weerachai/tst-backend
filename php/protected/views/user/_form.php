<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'user-form',
	'enableAjaxValidation' => false,
));
?>

<?php
	if (Yii::app()->user->checkAccess('admin')) {
		if (Yii::app()->user->getId() == $model->id)
			$roles = array('admin'=>'Admin');
		else
			$roles = array('user'=>'User','manager'=>'Manager','admin'=>'Admin');
	} else {
		if (Yii::app()->user->getId() == $model->id)
			$roles = array('manager'=>'Manager');
		else
			$roles = array('user'=>'User');
	}
?>
	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model, 'username', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'username'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model, 'password', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'password'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'repeat_password'); ?>
		<?php echo $form->passwordField($model, 'repeat_password', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'repeat_password'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'role'); ?>
		<?php echo $form->dropdownList($model,'role',$roles, array(
          	'ajax' => array(
            'type'=>'POST', //request type
            'url'=>CController::createUrl('/helper/getNoAccountUsers'),
            'dataType'=>'json',
                    'data'=>array('role'=>'js:this.value','id'=>$model->employee),
                    'success'=>'function(data) {
                        $("#User_employee").html(data.employee);
                    }',
          ))); ?>
		<?php echo $form->error($model,'role'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'employee'); ?>
		<?php echo $form->dropdownList($model,'employee',$model->role=='user'||empty($model->role)?Employee::model()->getNoAccountOptions($model->employee):array(''=>'-')); ?>
		<?php echo $form->error($model,'employee'); ?>
		</div><!-- row -->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->