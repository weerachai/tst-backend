<?php
/* @var $this ExportController */

$this->breadcrumbs=array(
    'ข้อมูล' => array('/data/'),
	'Data File Browser',
);

$this->menu = array(
	array('label'=>Yii::t('app', 'Upload File'), 'url' => array('browse/upload')),
);
?>

<h3>Data File Browser</h3>

<?php 

	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'horizontalForm',
		'action'=>Yii::app()->createUrl('/data/browse'),
		'type'=>'horizontal',
		'method'=>'GET',
	)); ?>
 
    <div class="form-actions">
    <?php echo CHtml::label('เลือก folder','folder'); ?>
	<?php echo CHtml::dropDownList('folder',$folder,$folders); ?> 
    <?php echo CHtml::label('ชนิดไฟล์','type'); ?>
	<?php echo CHtml::dropDownList('type',$type,array('txt'=>'Text','xls'=>'Excel')); ?> 
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Go')); ?>
    </div>
 
<?php $this->endWidget(); ?>
<?php
$this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'data-grid',
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
			'template' => ' {download} {delete}',
		    'buttons'=>array
			    (
			        'download' => array
			        (
			            'url'=>'Yii::app()->createUrl("/data/browse/download", array("file"=>$data["name"],"folder"=>$data["folder"]))',
                		'imageUrl'=>Yii::app()->request->baseUrl.'/images/download.png',
 			        ),
			        'delete' => array
			        (
			            'url'=>'Yii::app()->createUrl("/data/browse/delete", array("file"=>$data["name"],"folder"=>$data["folder"]))',
			        ),
			    ),
			'htmlOptions' => array('style'=>'white-space:nowrap'),		
		),
	),
)); ?>