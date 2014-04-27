<?php

$this->breadcrumbs = array(
	'User' => array('index'),
	Yii::t('app', 'Manage'),
);

$this->menu = array(
		array('label'=>Yii::t('app', 'Create') . ' User', 'url'=>array('create')),
	);

?>

<h1><?php echo Yii::t('app', 'Manage') . ' User'; ?></h1>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'user-grid',
	'filter'=>$filtersForm,
	'type'=>'striped bordered condensed',
	'dataProvider' => $dataProvider,
	'enablePagination' => true,
    'pager' => array(
        'cssFile' => false,
        'header' => false,
        'firstPageLabel' => 'หน้าแรก',
        'prevPageLabel' => 'หน้าก่อน',
        'nextPageLabel' => 'หน้าถัดไป',
        'lastPageLabel' => 'หน้าสุดท้าย',
    ),  
	'columns' => array(
		'id',
		'username',
//		'password',
		'name',
		'role',
		'employee',
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view} {update} {delete}',
            'htmlOptions' => array('style'=>'white-space:nowrap'),
			'buttons'=>array(
                'view' => array(
                  'url'=>'Yii::app()->createUrl("user/view", array("id"=>$data["id"]))',
                ),                  
                 'update' => array(
                  'url'=>'Yii::app()->createUrl("user/update", array("id"=>$data["id"]))',
                ),                  
             	'delete' => array(
	        	  'url'=>'Yii::app()->createUrl("user/delete", array("id"=>$data["id"]))',
 	              'visible'=>'$data["id"]!=Yii::app()->user->getId()',
            	),
			),
		),
	),
)); ?>