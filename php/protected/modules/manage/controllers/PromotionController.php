<?php

class PromotionController extends GxController
{
	public function actionIndex()
	{
		if (isset($_POST['SaleId'])) {
			$saleId = $_POST['SaleId'];
			$province = $_POST['Province'];
			$district = $_POST['District'];
			$subdistrict = $_POST['SubDistrict'];
			$sku = $_POST['PromotionSku'];
			$group = $_POST['PromotionGroup'];
			$bill = $_POST['PromotionBill'];
			$accu = $_POST['PromotionAccu'];
			$where = "SaleId = '$saleId' AND Province LIKE '$province' AND District LIKE '$district' AND SubDistrict LIKE '$subdistrict'";

			if (!empty($sku)) {
				$sql = "UPDATE Customer SET PromotionSku = '$sku' WHERE $where";
				Yii::app()->db->createCommand($sql)->execute();
			}
			if (!empty($group)) {
				$sql = "UPDATE Customer SET PromotionGroup = '$group' WHERE $where";
				Yii::app()->db->createCommand($sql)->execute();
			}
			if (!empty($bill)) {
				$sql = "UPDATE Customer SET PromotionBill = '$bill' WHERE $where";
				Yii::app()->db->createCommand($sql)->execute();
			}
			if (!empty($accu)) {
				$sql = "UPDATE Customer SET PromotionAccu = '$accu' WHERE $where";
				Yii::app()->db->createCommand($sql)->execute();
			}
			if (!empty($sku)||!empty($group)||!empty($bill)||!empty($accu)) {
				$sql = "UPDATE Customer SET UpdateAt = now() WHERE $where";
				Yii::app()->db->createCommand($sql)->execute();

			}
		}

		$sql = <<<SQL
		SELECT SaleId AS id, SaleId, SaleName, 
		Province, District, SubDistrict,
		PromotionSku, PromotionGroup, PromotionBill, PromotionAccu,
		COUNT(CustomerId) AS Num
		FROM SaleUnit JOIN Customer USING(SaleId)
		WHERE PromotionSku IS NOT NULL 
		OR PromotionGroup IS NOT NULL 
		OR PromotionBill IS NOT NULL 
		OR PromotionAccu IS NOT NULL 
		GROUP BY SaleId, Province, District, SubDistrict,
		PromotionSku, PromotionGroup, PromotionBill, PromotionAccu 
		ORDER BY SaleId, Province, District, SubDistrict
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
           	 	 'SaleId', 'SaleName', 'Province', 'District', 'SubDistrict', 'PromotionSku', 'PromotionGroup', 'PromotionBill', 'PromotionAccu'
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

	public function actionView($id, $province, $district, $subdistrict)
	{
		$sql = <<<SQL
		SELECT CustomerId AS id, CustomerId, CustomerName, 
		SaleId, SaleName, Province, District, SubDistrict,
		PromotionSku, PromotionGroup, PromotionBill, PromotionAccu 
		FROM SaleUnit JOIN Customer USING(SaleId)
		WHERE SaleId = '$id'
		AND Province = '$province' 
		AND District = '$district' 
		AND SubDistrict = '$subdistrict'
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
    		'dataProvider' => $dataProvider,
    		'model' => Customer::model()->findByPk($rawData[0]['id']),
		));
	}

	public function actionDelete($id,$province,$district,$subdistrict)
	{
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$sql = <<<SQL
			UPDATE Customer SET PromotionSku = NULL,
			PromotionGroup = NULL, PromotionBill = NULL, PromotionAccu = NULL
			WHERE SaleId = '$id' AND Province = '$province' AND District = '$district' AND SubDistrict = '$subdistrict'
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