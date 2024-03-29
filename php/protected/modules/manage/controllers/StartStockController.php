<?php

class StartStockController extends GxController
{
	public function filters() {
		return array('accessControl');
	}

	public function accessRules() {
		return array(
			array('allow', 
				'actions'=>array('index','delete'),
				'expression'=>'$user->checkAccess("operator")', 
			),
			array('deny', 
				'users'=>array('*'),
			),
		);
	}
	public function actionIndex()
	{
		$model = new StockStartList;

		$this->performAjaxValidation($model, 'stock-form');

		if (isset($_POST['StockStartList'])) {
			$model->setAttributes($_POST['StockStartList']);
			$model->UpdateAt = date("Y-m-d H:i:s");
			if ($model->save()) {
				$sid = $model->SaleId;
				$pid = $model->ProductId;
				$stock = Stock::model()->find("SaleId=? AND ProductId=?", array($sid,$pid));
				if ($stock) {
					$stock->delete();
				}
				$stock = new Stock();	
				$stock->SaleId = $sid;
				$stock->ProductId = $pid;
				$stock->StartQtyLevel1 = $model->QtyLevel1;
				$stock->StartQtyLevel2 = $model->QtyLevel2;
				$stock->StartQtyLevel3 = $model->QtyLevel3;
				$stock->StartQtyLevel4 = $model->QtyLevel4;
				$stock->CurrentQtyLevel1 = $model->QtyLevel1;
				$stock->CurrentQtyLevel2 = $model->QtyLevel2;
				$stock->CurrentQtyLevel3 = $model->QtyLevel3;
				$stock->CurrentQtyLevel4 = $model->QtyLevel4;
				$stock->UpdateAt = date("Y-m-d H:i:s");
				$stock->save();
				$model = new StockStartList;
			}
		}

		$model->SaleId = array_shift(array_keys(SaleUnit::model()->getStockSaleOptions()));
		$model->ProductId = array_shift(array_keys(StockStartList::model()->getProduct($model->SaleId,'','','','')));

		$sql = <<<SQL
		SELECT SaleId AS id, SaleName, T.ProductId, ProductName,
		QtyLevel1, PackLevel1, QtyLevel2, PackLevel2,
		QtyLevel3, PackLevel3, QtyLevel4, PackLevel4, T.UpdateAt
		FROM (StockStartList JOIN SaleUnit USING(SaleId))
			JOIN Product T USING (ProductId)
		ORDER BY SaleName, ProductName
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
           	 	 'SaleName', 'ProductName'
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
    		'model' => $model
		));
	}

	public function actionDelete($saleId, $productId)
	{
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$sql = <<<SQL
			DELETE FROM StockStartList
			WHERE SaleId = '$saleId'
			AND ProductId = '$productId'
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