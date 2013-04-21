<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

$this->menu=array(
                  array('label'=>'Manage User', 'url'=>array('user/admin'), 'visible'=>Yii::app()->user->checkaccess('admin')),
                  array('label'=>'View Profile', 'url'=>array('user/view&id='.Yii::app()->user->getId()), 'visible'=>Yii::app()->user->checkaccess('user')),
);
?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

