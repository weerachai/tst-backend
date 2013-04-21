<?php
/* @var $this OCustomerTitleController */
/* @var $model OCustomerTitle */

$this->breadcrumbs=array(
	'Ocustomer Titles'=>array('index'),
	$model->TitleId,
);

$this->menu=array(
	array('label'=>'List OCustomerTitle', 'url'=>array('index')),
	array('label'=>'Create OCustomerTitle', 'url'=>array('create')),
	array('label'=>'Update OCustomerTitle', 'url'=>array('update', 'id'=>$model->TitleId)),
	array('label'=>'Delete OCustomerTitle', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->TitleId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OCustomerTitle', 'url'=>array('admin')),
);
?>

<h1>View OCustomerTitle #<?php echo $model->TitleId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'TitleId',
		'TitleName',
		'UpdateAt',
	),
)); ?>
