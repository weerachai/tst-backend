<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Create User', 'url'=>array('create'), 'visible'=>Yii::app()->user->checkaccess('admin')),
	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>Yii::app()->user->checkaccess('admin')),
	array('label'=>'Manage User', 'url'=>array('admin'), 'visible'=>Yii::app()->user->checkaccess('admin')),
);
?>

<h1>View User <?php echo $model->username; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
                            //		'id',
		'username',
                //		'password',
		'name',
		'role',
	),
)); ?>
