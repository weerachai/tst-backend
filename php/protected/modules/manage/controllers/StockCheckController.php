<?php

class StockCheckController extends GxController
{
	public function actionIndex()
	{

		if (isset($_POST['SaleId']) && isset($_POST['GrpLevel1Id']) && !empty($_POST['GrpLevel1Id'])) {
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
		SELECT SaleId AS id, SaleName, GrpLevel1Name, GrpLevel1.GrpLevel1Id,
		GrpLevel2Name, GrpLevel2.GrpLevel2Id, GrpLevel3Name, GrpLevel3.GrpLevel3Id,
		Product.ProductId, ProductName
		FROM ((((StockCheckList JOIN SaleUnit USING(SaleId))
		LEFT JOIN GrpLevel1 USING(GrpLevel1Id))
		LEFT JOIN GrpLevel2 USING(GrpLevel2Id))
		LEFT JOIN GrpLevel3 USING(GrpLevel3Id))
		LEFT JOIN Product USING (ProductId)
		ORDER BY SaleName, GrpLevel1Name, GrpLevel2Name, GrpLevel3Name, ProductName
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
           	 	 'SaleName', 'GrpLevel1Name', 'GrpLevel2Name', 'GrpLevel3Name', 'ProductName'
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