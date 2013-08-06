<?php

class StartStockController extends GxController
{
	public function actionIndex()
	{

		if (isset($_POST['SaleId']) && isset($_POST['ProductId']) && !empty($_POST['ProductId'])) {
			$saleId = $_POST['SaleId'];
			$grpLevel1Id = $_POST['GrpLevel1Id'];
			$grpLevel2Id = $_POST['GrpLevel2Id'];
			$grpLevel3Id = $_POST['GrpLevel3Id'];
			$productId = $_POST['ProductId'];

			$sql = <<<SQL
				INSERT INTO StockCheckList 
				VALUES('$saleId','$grpLevel1Id','$grpLevel2Id','$grpLevel3Id','$productId',now())
SQL;
			Yii::app()->db->createCommand($sql)->execute();
		}

		$sql = <<<SQL
			SELECT SaleId AS id, SaleName, Product.ProductId, ProductName,
			1 AS Level, Qty, PackLevel1 AS Pack
			FROM (StockStartList JOIN SaleUnit USING(SaleId))
			JOIN Product USING (ProductId)
		UNION
			SELECT SaleId AS id, SaleName, Product.ProductId, ProductName,
			2 AS Level, Qty, PackLevel2 AS Pack
			FROM (StockStartList JOIN SaleUnit USING(SaleId))
			JOIN Product USING (ProductId)
		UNION
			SELECT SaleId AS id, SaleName, Product.ProductId, ProductName,
			3 AS Level, Qty, PackLevel3 AS Pack
			FROM (StockStartList JOIN SaleUnit USING(SaleId))
			JOIN Product USING (ProductId)
		UNION
			SELECT SaleId AS id, SaleName, Product.ProductId, ProductName,
			4 AS Level, Qty, PackLevel4 AS Pack
			FROM (StockStartList JOIN SaleUnit USING(SaleId))
			JOIN Product USING (ProductId)
		ORDER BY SaleName, ProductName, Level
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

		$model = new StockStartList;

		$this->performAjaxValidation($model, 'stock-form');

		if (isset($_POST['StockStartList'])) {
			$model->setAttributes($_POST['StockStartList']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
			}
		}

		// Render
		$this->render('index', array(
    		'filtersForm' => $filtersForm,
    		'dataProvider' => $dataProvider,
    		'model' => $model
		));
	}

	public function actionDelete($saleId, $grpLevel1Id, $grpLevel2Id, $grpLevel3Id, $productId)
	{
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$sql = <<<SQL
			DELETE FROM StockCheckList
			WHERE SaleId = '$saleId'
			AND GrpLevel1Id = '$grpLevel1Id' AND GrpLevel2Id = '$grpLevel2Id'
			AND GrpLevel3Id = '$grpLevel3Id' AND ProductId = '$productId'
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