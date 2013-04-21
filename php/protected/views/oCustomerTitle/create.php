<?php
/* @var $this OCustomerTitleController */
/* @var $model OCustomerTitle */

$this->breadcrumbs=array(
	'Ocustomer Titles'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OCustomerTitle', 'url'=>array('index')),
	array('label'=>'Manage OCustomerTitle', 'url'=>array('admin')),
);
?>

<h1>Create OCustomerTitle</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>