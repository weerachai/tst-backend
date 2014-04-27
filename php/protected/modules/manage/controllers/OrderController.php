<?php

class OrderController extends GxController {

	public function filters() {
		return array('accessControl');
	}

	public function accessRules() {
		return array(
			array('allow', 
				'actions'=>array('index'),
				'expression'=>'$user->checkAccess("operator")', 
			),
			array('deny', 
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex() {
		unset(Yii::app()->request->cookies['from_date']);  // first unset cookie for dates
		unset(Yii::app()->request->cookies['to_date']);
 
 		$from_date = '';
 		$to_date = '';
		if(isset($_POST['from_date']))
  		{
  			Yii::app()->request->cookies['from_date'] = new CHttpCookie('from_date', $_POST['from_date']);
    		$from_date = $_POST['from_date'];
		} elseif(isset(Yii::app()->request->cookies['from_date'])) {
			$from_date=Yii::app()->request->cookies['from_date'];
		}
		if(isset($_POST['to_date']))
  		{
  			Yii::app()->request->cookies['to_date'] = new CHttpCookie('to_date', $_POST['to_date']);
    		$to_date = $_POST['to_date'];
		} elseif(isset(Yii::app()->request->cookies['to_date'])) {
			$to_date=Yii::app()->request->cookies['to_date'];
		}
		if (empty($from_date))
			$from_date = '2000-01-01';
		if (empty($to_date))
			$to_date = '2099-12-31';

		$sql = <<<SQL
		SELECT OrderNo AS id, OrderDate, InvoiceNo,
		CONCAT(FirstName,' ',LastName) As Name, SaleName, 
		O.Status OrderStatus, I.Status InvoiceStatus
		FROM ((ProductOrder O JOIN SaleUnit USING(SaleId))
		JOIN Employee USING(EmployeeId))
		LEFT JOIN ProductInvoice I USING(OrderNo)
		WHERE OrderDate >= '$from_date' AND OrderDate <= '$to_date'
		ORDER BY id
SQL;

		echo $sql;
		// Create filter model and set properties
		$filtersForm = new FiltersForm;
		if (isset($_GET['FiltersForm']))
		    $filtersForm->filters=$_GET['FiltersForm'];
		 
		// Get rawData and create dataProvider
		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		$filteredData = $filtersForm->filter($rawData);
		$dataProvider = new CArrayDataProvider($filteredData, array(
    		'sort'=>array(
        		'attributes'=>array(
           	 	 'id', 'OrderDate', 'InvoiceNo', 'Name', 'SaleName', 'OrderStatus', 'InvoiceStatus'
        		),
    		),
    		'pagination'=>array(
        		'pageSize'=>10,
    		),
		));

		// Render
		$this->render('index', array(
    		'filtersForm' => $filtersForm,
    		'dataProvider' => $dataProvider,
		));
	}

}