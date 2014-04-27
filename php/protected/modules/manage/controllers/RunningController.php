<?php

class RunningController extends GxController
{
	public function filters() {
		return array('accessControl');
	}

	public function accessRules() {
		return array(
			array('allow', 
				'actions'=>array('index','update'),
				'expression'=>'$user->checkAccess("operator")', 
			),
			array('deny', 
				'users'=>array('*'),
			),
		);
	}
	public function actionIndex($updated = false)
	{
		$sql = <<<SQL
		SELECT DeviceId AS id, DeviceId, 
		CONCAT(FirstName,' ',LastName) AS Name, SaleId,
		ControlId, ControlName, Prefix, Year, Month, No 
		FROM (((SaleUnit JOIN Device USING(SaleId))
		JOIN Employee USING(EmployeeId)) 
		JOIN ControlNo USING(SaleId))
		JOIN ControlRunning USING(ControlId)
		ORDER BY Name, ControlName
SQL;

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
            	 	 'DeviceId', 'Name', 'ControlName',
        		),
    		),
    		'pagination'=>array(
        		'pageSize'=>12,
    		),
		));

		if ($updated)
			$message = 'Update ข้อมูลแล้ว';
		else
			$message = '';
		// Render
		$this->render('index', array(
    		'message' => $message,
    		'filtersForm' => $filtersForm,
    		'dataProvider' => $dataProvider,
		));
	}

	public function actionUpdate($saleId, $controlId)
	{
		$sql = <<<SQL
		UPDATE ControlNo SET UpdateAt = now()
		WHERE SaleId = '$saleId' AND ControlId = '$controlId'
SQL;
		Yii::app()->db->createCommand($sql)->execute();
		$this->redirect(array('index', 'updated' => true));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}