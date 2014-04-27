<?php

class StockCheckController extends GxController
{
	public function filters() {
		return array('accessControl');
	}

	public function accessRules() {
		return array(
			array('allow', 
				'actions'=>array('index','add','delete'),
				'expression'=>'$user->checkAccess("operator")', 
			),
			array('deny', 
				'users'=>array('*'),
			),
		);
	}
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

	public function actionAdd() {
		$SaleId = isset($_POST['SaleId'])? $_POST['SaleId'] : array_shift(array_keys(SaleUnit::model()->getOptions()));;
		if (isset($_POST['ids'])) {
			$this->batchAdd($SaleId, $_POST['ids']);
			return;
		}
		$GrpLevel1Id = isset($_POST['GrpLevel1Id'])? $_POST['GrpLevel1Id'] : '%';
		$GrpLevel2Id = isset($_POST['GrpLevel2Id'])? $_POST['GrpLevel2Id'] : '%';
		$GrpLevel3Id = isset($_POST['GrpLevel3Id'])? $_POST['GrpLevel3Id'] : '%';		
		if (empty($GrpLevel1Id))
			$GrpLevel1Id = '%';
		if (empty($GrpLevel2Id))
			$GrpLevel2Id = '%';
		if (empty($GrpLevel3Id))
			$GrpLevel3Id = '%';
		$sql = <<<SQL
			SELECT ProductId AS id, ProductId, ProductName
			FROM Product
			WHERE Product.GrpLevel1Id LIKE '$GrpLevel1Id' AND
			Product.GrpLevel2Id LIKE '$GrpLevel2Id' AND
			Product.GrpLevel3Id LIKE '$GrpLevel3Id' AND
			ProductId NOT IN (
				SELECT P.ProductId 
				FROM Product P JOIN StockCheckList S 
				USING(GrpLevel1Id, GrpLevel2Id, GrpLevel3Id, ProductId)
				WHERE SaleId='$SaleId'
				UNION
				SELECT P.ProductId 
				FROM Product P JOIN StockCheckList S 
				USING(GrpLevel1Id, GrpLevel2Id, GrpLevel3Id) 
				WHERE SaleId='$SaleId' AND S.ProductId = ''
				UNION
				SELECT P.ProductId 
				FROM Product P JOIN StockCheckList S 
				USING(GrpLevel1Id, GrpLevel2Id) 
				WHERE SaleId='$SaleId' AND S.GrpLevel3Id = '' 
				AND S.ProductId = ''
				UNION
				SELECT P.ProductId 
				FROM Product P JOIN StockCheckList S 
				USING(GrpLevel1Id) 
				WHERE SaleId='$SaleId' AND S.GrpLevel2Id = '' 
				AND S.GrpLevel3Id = '' AND S.ProductId = ''
			)
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
           	 	 'ProductId', 'ProductName'
        		),
    		),
    		'pagination'=>array(
        		'pageSize'=>count($rawData),
    		),
		));

		// Render
		$this->render('add', array(
    		'filtersForm' => $filtersForm,
    		'dataProvider' => $dataProvider,
    		'SaleId' => $SaleId,
    		'GrpLevel1Id' => (isset($_POST['GrpLevel1Id'])? $_POST['GrpLevel1Id'] : ''),
    		'GrpLevel2Id' => (isset($_POST['GrpLevel2Id'])? $_POST['GrpLevel2Id'] : ''),
    		'GrpLevel3Id' => (isset($_POST['GrpLevel3Id'])? $_POST['GrpLevel3Id'] : ''),
		));
	}

 	private function batchAdd($saleId, $ids) {
 		foreach ($ids as $id) {
 			$model = Product::model()->findByPk($id);
 			if ($model) {
 				$grp1 = $model->GrpLevel1Id;
 				$grp2 = $model->GrpLevel2Id;
 				$grp3 = $model->GrpLevel3Id;
 				$sql = <<<SQL
					INSERT INTO StockCheckList 
					VALUES('$saleId','$grp1','$grp2','$grp3','$id',now())
SQL;
				Yii::app()->db->createCommand($sql)->execute();
			}
		}
 		$this->redirect(array('index'));
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