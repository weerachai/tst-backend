<?php
/* @var $this OCustomerTitleController */
/* @var $model OCustomerTitle */

$this->breadcrumbs=array(
	'Ocustomer Titles'=>array('index'),
	$model->TitleId=>array('view','id'=>$model->TitleId),
	'Update',
);

$this->menu=array(
	array('label'=>'List OCustomerTitle', 'url'=>array('index')),
	array('label'=>'Create OCustomerTitle', 'url'=>array('create')),
	array('label'=>'View OCustomerTitle', 'url'=>array('view', 'id'=>$model->TitleId)),
	array('label'=>'Manage OCustomerTitle', 'url'=>array('admin')),
);
?>

<h1>Update OCustomerTitle <?php echo $model->TitleId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>