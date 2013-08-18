<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'mydialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Dialog box 1',
        'autoOpen'=>false,
    ),
));

echo 'dialog content here';

$this->endWidget('zii.widgets.jui.CJuiDialog');

$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'install-grid',
	'dataProvider' => $dataProvider,
	'columns' => array(
		'name',
		'size',
		'create_time',
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'template' => ' {download} {restore} {delete}',
			  'buttons'=>array
			    (
			        'download' => array
			        (
			            'url'=>'Yii::app()->createUrl("backup/default/download", array("file"=>$data["name"]))',
                		'imageUrl'=>Yii::app()->request->baseUrl.'/images/download.png',
 			        ),
			        'restore' => array
			        (
			            'url'=>'Yii::app()->createUrl("backup/default/restore", array("file"=>$data["name"]))',
                		'imageUrl'=>Yii::app()->request->baseUrl.'/images/restore.png',
 						'click'=>'function(){return confirm("คุณแน่ใจหรือไม่? ข้อมูลจะถูกเขียนทับทั้งหมด");}',
					),
			        'delete' => array
			        (
			            'url'=>'Yii::app()->createUrl("backup/default/delete", array("file"=>$data["name"]))',
			        ),
			    ),		
		),
	),
)); ?>