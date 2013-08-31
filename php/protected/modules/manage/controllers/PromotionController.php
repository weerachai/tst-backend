<?php

class PromotionController extends GxController
{
	public function actionIndex()
	{
		if (isset($_POST['SaleId'])) {
			$saleId = $_POST['SaleId'];
			$sku = $_POST['PromotionSku'];
			$group = $_POST['PromotionGroup'];
			$bill = $_POST['PromotionBill'];
			$accu = $_POST['PromotionAccu'];
			if (!empty($sku)) {
				$sql = "UPDATE DeviceSetting SET PromotionSku = '$sku' WHERE SaleId = '$saleId'";
				Yii::app()->db->createCommand($sql)->execute();
			}
			if (!empty($group)) {
				$sql = "UPDATE DeviceSetting SET PromotionGroup = '$group' WHERE SaleId = '$saleId'";
				Yii::app()->db->createCommand($sql)->execute();
			}
			if (!empty($bill)) {
				$sql = "UPDATE DeviceSetting SET PromotionBill = '$bill' WHERE SaleId = '$saleId'";
				Yii::app()->db->createCommand($sql)->execute();
			}
			if (!empty($accu)) {
				$sql = "UPDATE DeviceSetting SET PromotionAccu = '$accu' WHERE SaleId = '$saleId'";
				Yii::app()->db->createCommand($sql)->execute();
			}
		}

		$sql = <<<SQL
		SELECT SaleId AS id, SaleId, SaleName, 
		PromotionSku, PromotionGroup, PromotionBill, PromotionAccu 
		FROM SaleUnit JOIN DeviceSetting USING(SaleId)
		WHERE PromotionSku IS NOT NULL 
		OR PromotionGroup IS NOT NULL 
		OR PromotionBill IS NOT NULL 
		OR PromotionAccu IS NOT NULL 
		ORDER BY SaleId
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
           	 	 'SaleId', 'SaleName', 'PromotionSku', 'PromotionGroup', 'PromotionBill', 'PromotionAccu'
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

	public function actionDelete($id)
	{
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$sql = <<<SQL
			UPDATE DeviceSetting SET PromotionSku = NULL,
			PromotionGroup = NULL, PromotionBill = NULL, PromotionAccu = NULL
			WHERE SaleId = '$id'
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