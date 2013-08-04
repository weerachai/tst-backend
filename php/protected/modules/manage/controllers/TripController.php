<?php

class TripController extends GxController
{
	public function actionIndex()
	{

		if (isset($_POST['SaleId']) && isset($_POST['Trip'])
			&& isset($_POST['Province']) && !empty($_POST['Trip']) && !empty($_POST['Province'])) {
			$saleId = $_POST['SaleId'];
			$trip = $_POST['Trip'];
			$province = $_POST['Province'];
			$district = $_POST['District'];
			$subdistrict = $_POST['SubDistrict'];
			if (empty($district))
				$district = "%";
			if (empty($subdistrict))
				$subdistrict = "%";

			$sql = <<<SQL
					UPDATE Customer SET Trip1 = '$trip'
					WHERE SaleId = '$saleId' 
					AND (Trip1 IS NULL OR Trip1 = '')
					AND (Trip2 IS NULL OR Trip2 != '$trip')
					AND (Trip3 IS NULL OR Trip3 != '$trip')
					AND Province = '$province' AND
					District LIKE '$district' AND SubDistrict LIKE '$subdistrict'
SQL;
			Yii::app()->db->createCommand($sql)->execute();

			$sql = <<<SQL
					UPDATE Customer SET Trip2 = '$trip'
					WHERE SaleId = '$saleId' 
					AND (Trip1 IS NULL OR Trip1 != '$trip')
					AND (Trip2 IS NULL OR Trip2 = '')
					AND (Trip3 IS NULL OR Trip3 != '$trip')
					AND Province = '$province' AND
					District LIKE '$district' AND SubDistrict LIKE '$subdistrict'
SQL;
			Yii::app()->db->createCommand($sql)->execute();

			$sql = <<<SQL
					UPDATE Customer SET Trip3 = '$trip'
					WHERE SaleId = '$saleId' 
					AND (Trip1 IS NULL OR Trip1 != '$trip')
					AND (Trip2 IS NULL OR Trip2 != '$trip')
					AND (Trip3 IS NULL OR Trip3 = '')
					AND Province = '$province' AND
					District LIKE '$district' AND SubDistrict LIKE '$subdistrict'
SQL;
			Yii::app()->db->createCommand($sql)->execute();

		}

		$sql = <<<SQL
		SELECT DeviceId AS id, DeviceId, Name, 
		Trip, TripId, Province, District, SubDistrict, SaleId,
		COUNT(CustomerId) AS Num
		FROM (
			SELECT DeviceId AS id, DeviceId, CONCAT(FirstName,' ',LastName) AS Name,
			Trip1 AS Trip, TripId, Province, District, SubDistrict, CustomerId, SaleId
			FROM (((Customer JOIN SaleUnit USING(SaleId)) JOIN Device USING(SaleId))
			JOIN Employee USING(EmployeeId)) JOIN Trip ON TripName = Trip1
			WHERE Trip1 IS NOT NULL && Trip1 <> ''
			UNION 
			SELECT DeviceId AS id, DeviceId, CONCAT(FirstName,' ',LastName) AS Name,
			Trip2 AS Trip, TripId, Province, District, SubDistrict, CustomerId, SaleId
			FROM (((Customer JOIN SaleUnit USING(SaleId)) JOIN Device USING(SaleId))
			JOIN Employee USING(EmployeeId)) JOIN Trip ON TripName = Trip2
			WHERE Trip2 IS NOT NULL && Trip2 <> ''
			UNION 
			SELECT DeviceId AS id, DeviceId, CONCAT(FirstName,' ',LastName) AS Name,
			Trip3 AS Trip, TripId, Province, District, SubDistrict, CustomerId, SaleId
			FROM (((Customer JOIN SaleUnit USING(SaleId)) JOIN Device USING(SaleId))
			JOIN Employee USING(EmployeeId)) JOIN Trip ON TripName = Trip3
			WHERE Trip3 IS NOT NULL && Trip3 <> ''
		) AS t
		GROUP BY id, DeviceId, Name, Trip, TripId, Province, District, SubDistrict, SaleId
		ORDER BY DeviceId, Name, TripId, Province, District, SubDistrict
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
           	 	 'DeviceId', 'Name', 'Trip', 'Province', 'District', 'SubDistrict', 'Num'
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

	public function actionView($saleId, $trip, $province, $district, $subdistrict)
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
		WHERE (Trip1 = '$trip' OR Trip2 = '$trip' OR Trip3 = '$trip')
		AND Province LIKE '$province' 
		AND District LIKE '$district' 
		AND SubDistrict LIKE '$subdistrict'
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
    		'trip' => $trip,
    		'title' => $title,
    		'dataProvider' => $dataProvider,
		));
	}

	public function actionDelete($saleId, $trip, $province, $district, $subdistrict)
	{
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$sql = <<<SQL
			UPDATE Customer SET Trip1 = NULL
			WHERE SaleId = '$saleId' AND Trip1 = '$trip'
			AND Province = '$province' 
			AND District = '$district' 
			AND SubDistrict = '$subdistrict'
SQL;
			Yii::app()->db->createCommand($sql)->execute();

			$sql = <<<SQL
			UPDATE Customer SET Trip2 = NULL
			WHERE SaleId = '$saleId' AND Trip2 = '$trip'
			AND Province = '$province' 
			AND District = '$district' 
			AND SubDistrict = '$subdistrict'
SQL;
			Yii::app()->db->createCommand($sql)->execute();

			$sql = <<<SQL
			UPDATE Customer SET Trip3 = NULL
			WHERE SaleId = '$saleId' AND Trip3 = '$trip'
			AND Province = '$province' 
			AND District = '$district' 
			AND SubDistrict = '$subdistrict'
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