<?php

class CustomerController extends GxController
{
	public function filters() {
		return array('accessControl');
	}

	public function accessRules() {
		return array(
			array('allow', 
				'actions'=>array('index','view','delete'),
				'expression'=>'$user->checkAccess("operator")', 
			),
			array('deny', 
				'users'=>array('*'),
			),
		);
	}
	public function actionIndex()
	{

		if (isset($_POST['SaleId']) && isset($_POST['Province']) && !empty($_POST['Province'])) {
			$saleId = $_POST['SaleId'];
			$province = $_POST['Province'];
			$district = $_POST['District'];
			$subdistrict = $_POST['SubDistrict'];
			if (empty($district))
				$district = "%";
			if (empty($subdistrict))
				$subdistrict = "%";

			$sql = <<<SQL
					UPDATE Customer SET SaleId = '$saleId'
					WHERE Province = '$province' AND
					District LIKE '$district' AND SubDistrict LIKE '$subdistrict'
SQL;
			Yii::app()->db->createCommand($sql)->execute();
		}

		$sql = <<<SQL
		SELECT SaleId AS id, SaleId, SaleName, 
		Province, District, SubDistrict, 
		COUNT(CustomerId) AS Num
		FROM Customer JOIN SaleUnit USING(SaleId)
		GROUP BY id, SaleId, SaleName, Province,
		District, SubDistrict
		ORDER BY Province, District, SubDistrict
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
           	 	 'SaleId', 'SaleName', 'Province', 'District', 'SubDistrict', 'Num'
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

	public function actionView($province, $district, $subdistrict)
	{
		$title = "จังหวัด$province";
		if (!empty($district))
			$title = "อำเภอ$district $title";
		if (!empty($subdistrict))
			$title = "ตำบล$subdistrict $title";

		$province = empty($province) ? "%" : $province;
		$district = empty($district) ? "%" : $district;
		$subdistrict = empty($subdistrict) ? "%" : $subdistrict;

		$sql = <<<SQL
		SELECT CustomerId AS id, CustomerId, CustomerName
		FROM Customer
		WHERE Province LIKE '$province' AND
		District LIKE '$district' AND SubDistrict LIKE '$subdistrict'
		ORDER BY CustomerName
SQL;

		// Get rawData and create dataProvider
		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		$dataProvider = new CArrayDataProvider($rawData, array(
    		'pagination'=>array(
        		'pageSize'=>10,
    		),
		));

		// Render
		$this->render('view', array(
    		'title' => $title,
    		'dataProvider' => $dataProvider,
		));
	}

	public function actionDelete($province, $district, $subdistrict)
	{
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$sql = <<<SQL
			UPDATE Customer SET SaleId = NULL
			WHERE Province LIKE '$province' AND
			District LIKE '$district' AND SubDistrict LIKE '$subdistrict'
SQL;
			Yii::app()->db->createCommand($sql)->execute();
			$this->redirect(array('index'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
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