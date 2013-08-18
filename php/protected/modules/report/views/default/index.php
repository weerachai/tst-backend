<?php
/* @var $this Report */

$this->breadcrumbs=array(
    'รายงาน'
);
?>

<h3>พิมพ์รายงาน</h3>
<div>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>

<b> เริ่มวันที่ : </b>
<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'from_date',  // name of post parameter
    'value'=>$from_date,  // value comes from cookie after submittion
     'options'=>array(
        'showAnim'=>'fold',
        'dateFormat'=>'yy-mm-dd',
    ),
    'htmlOptions'=>array(
        'style'=>'height:20px;'
    ),
));
?>
<b> ถึงวันที่ : </b>
<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'to_date',
    'value'=>$to_date,
     'options'=>array(
        'showAnim'=>'fold',
        'dateFormat'=>'yy-mm-dd',
 
    ),
    'htmlOptions'=>array(
        'style'=>'height:20px;'
    ),
));
?>
<br />
<b> รายงาน : </b>
<?php echo CHtml::dropDownList('report', $report, $reportList); ?>

<b> Format : </b>
<?php echo CHtml::dropDownList('format', $format, array('Excel'=>'Excel','Pdf'=>'Pdf')); ?>

<p><h4 style="color:red;"><?php echo $error; ?></h4>

<?php 

$columns = array(
	array(
        'class'=>'CCheckBoxColumn',
        'checkBoxHtmlOptions' => array(
            'name' => 'ids[]',
        ),
        'selectableRows' => 2,
    ),
    array(
        'header'=>CHtml::encode('หน่วยขาย'),
        'name'=>'SaleName',
        'htmlOptions' => array('style'=>'white-space:nowrap'),
    ),
);

$this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'data-grid',
	'type'=>'striped bordered condensed',
  	'dataProvider' => $dataProvider,
	'enablePagination' => false,
	'columns' => $columns,
));
?>

<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Export')); ?>

<?php $this->endWidget(); ?>

</div>
