<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'View'),
);

if (Yii::app()->user->checkAccess('manager')) {
	$this->menu=array(
		array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
		array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->id)),
	);	
	if ($model->id != Yii::app()->user->getId())
		array_push($this->menu, array('label'=>Yii::t('app', 'Delete') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm'=>'Are you sure you want to delete this item?')));
	array_push($this->menu, array('label'=>Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url'=>array('admin')));
} else {
	$this->menu=array(
		array('label'=>'Change Password ', 'url'=>array('password', 'id' => $model->id)),
	);		
}
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
'id',
'username',
//'password',
'name',
'role',
'employee',
	),
)); ?>

