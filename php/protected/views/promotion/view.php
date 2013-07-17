<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
	array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->PromotionId)),
	array('label'=>Yii::t('app', 'Delete') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->PromotionId), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
'PromotionGroup',
'PromotionId',
'StartDate',
'EndDate',
'PromotionType',
'ProductOrGrpId',
'MinAmount',
'MinSku',
'MinQty',
'Pack',
'DiscBaht',
'DiscPerAmount',
'DiscPerQty',
'DiscPer1',
'DiscPer2',
'DiscPer3',
'FreeType',
'FreeProductOrGrpId',
'FreeQty',
'FreePack',
'FreePerAmount',
'FreePerQty',
'FreeBaht',
'Formula',
'UpdateAt',
	),
)); ?>

