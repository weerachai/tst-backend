<?php
/* @var $this CustomerController */
/* @var $model Customer */

$this->breadcrumbs=array(
	'Customers'=>array('index'),
	$model->Title,
);

$this->menu=array(
	array('label'=>'List Customer', 'url'=>array('index')),
	array('label'=>'Create Customer', 'url'=>array('create')),
	array('label'=>'Update Customer', 'url'=>array('update', 'id'=>$model->CustomerId)),
	array('label'=>'Delete Customer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->CustomerId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Customer', 'url'=>array('admin')),
);
?>

<h1>View Customer #<?php echo $model->CustomerId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'CustomerId',
		'DeviceId',
		'SaleId',
		'Title',
		'CustomerName',
		'Type',
		'Trip1',
		'Trip2',
		'Trip3',
		'Province',
		'District',
		'SubDistrict',
		'ZipCode',
		'AddrNo',
		'Moo',
		'Village',
		'Soi',
		'Road',
		'Phone',
		'ContactPerson',
		'Promotion',
		'CreditTerm',
		'CreditLimit',
		'OverCreditType',
		'Due',
		'PoseCheck',
		'ReturnCheck',
		'NewFlag',
		'UpdateAt',
	),
)); ?>
