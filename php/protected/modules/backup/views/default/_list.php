<?php 

$this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'install-grid',
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
   	'type'=>'striped bordered condensed',
	'columns' => array(
	    array(
	        'header'=>CHtml::encode('ชื่อไฟล์'),
	        'name'=>'name',
	        'htmlOptions' => array('style'=>'white-space:nowrap'),
	    ),
	    array(
	        'header'=>CHtml::encode('ขนาด'),
	        'name'=>'size',
	        'htmlOptions' => array('style'=>'white-space:nowrap'),
	    ),
	    array(
	        'header'=>CHtml::encode('เวลาบันทึก'),
	        'name'=>'create_time',
	        'htmlOptions' => array('style'=>'white-space:nowrap'),
	    ),
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
			'htmlOptions' => array('style'=>'white-space:nowrap'),		
		),
	),
)); ?>