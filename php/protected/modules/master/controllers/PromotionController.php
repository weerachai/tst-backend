<?php

class PromotionController extends GxController {

	public function filters() {
		return array('accessControl');
	}

	public function accessRules() {
		return array(
			array('allow', 
				'actions'=>array('index','view','create','update','copy','delete','deleteProductGroup','deleteFreeGroup'),
				'expression' => '$user->checkAccess("operator")', 
			),
			array('deny', 
				'users'=>array('*'),
			),
		);
	}

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Promotion'),
		));
	}

	public function actionCreate($type) {
		$model = new Promotion;
		if ($type != 'accu')
			$model->PromotionType = $type;

		$this->performAjaxValidation($model, 'promotion-form');

		if (isset($_POST['Promotion'])) {
			$model->setAttributes($_POST['Promotion']);
			$model->UpdateAt = date("Y-m-d H:i:s");
			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->PromotionId));
			}
		}

		$this->render('create', array( 'model' => $model, 'type' => $type));
	}

	public function actionCopy($id) {
		$model = new Promotion;
		$copy = $this->loadModel($id, 'Promotion');

		$model->attributes = $copy->attributes;

		$this->performAjaxValidation($model, 'promotion-form');

		if (isset($_POST['Promotion'])) {
			$model->setAttributes($_POST['Promotion']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->PromotionId));
			}
		}

		$this->render('create', array( 'model' => $model, 'type' => $model->PromotionType));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Promotion');
		if ($model->PromotionType == 'sku' || $model->PromotionType == 'group' || $model->PromotionType == 'bill')
			$type = $model->PromotionType;
		else
			$type = 'accu';

		$this->performAjaxValidation($model, 'promotion-form');

		if (isset($_POST['Promotion'])) {
			$model->setAttributes($_POST['Promotion']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->PromotionId));
			}
		}

		$this->render('update', array(
				'model' => $model,
				'type' => $type,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Promotion')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('index'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$from_date = isset($_POST['from_date'])? $_POST['from_date'] : '';
		$to_date = isset($_POST['to_date']) ? $_POST['to_date'] : '';

		$from_date_sql = empty($from_date) ? '2000-01-01' : $from_date;
		$to_date_sql = empty($to_date) ? '2099-12-31' : $to_date;

		if ($to_date_sql <= $from_date_sql) {
			$to_date_sql = $from_date_sql;
			$to_date = $from_date;
		}

		$sql = <<<SQL
		SELECT PromotionId AS id, PromotionGroup, PromotionId, 
		StartDate, EndDate, PromotionType, ProductOrGrpId,
		ProductName AS ProductOrGrpName,
		MinAmount, MinSku, MinQty, Pack
		FROM Promotion JOIN Product ON ProductOrGrpId = ProductId
		WHERE PromotionType LIKE '%sku' AND
		((StartDate <= '$from_date_sql' AND EndDate >= '$from_date_sql') 
		OR (StartDate <= '$to_date_sql' AND EndDate >= '$to_date_sql')
		OR (StartDate >= '$from_date_sql' AND EndDate <= '$to_date_sql'))
		
		UNION
		
		SELECT PromotionId AS id, PromotionGroup, PromotionId, 
		StartDate, EndDate, PromotionType, ProductOrGrpId,
		GrpLevel1Name AS ProductOrGrpName,
		MinAmount, MinSku, MinQty, Pack
		FROM Promotion JOIN GrpLevel1 ON ProductOrGrpId = GrpLevel1Id
		WHERE PromotionType = 'accu-l1' AND
		((StartDate <= '$from_date_sql' AND EndDate >= '$from_date_sql') 
		OR (StartDate <= '$to_date_sql' AND EndDate >= '$to_date_sql')
		OR (StartDate >= '$from_date_sql' AND EndDate <= '$to_date_sql'))
		
		UNION
		
		SELECT PromotionId AS id, PromotionGroup, PromotionId, 
		StartDate, EndDate, PromotionType, ProductOrGrpId,
		GrpLevel2Name AS ProductOrGrpName,
		MinAmount, MinSku, MinQty, Pack
		FROM Promotion JOIN GrpLevel2 ON ProductOrGrpId = GrpLevel2Id
		WHERE PromotionType = 'accu-l1' AND
		((StartDate <= '$from_date_sql' AND EndDate >= '$from_date_sql') 
		OR (StartDate <= '$to_date_sql' AND EndDate >= '$to_date_sql')
		OR (StartDate >= '$from_date_sql' AND EndDate <= '$to_date_sql'))
		
		UNION
		
		SELECT PromotionId AS id, PromotionGroup, PromotionId, 
		StartDate, EndDate, PromotionType, ProductOrGrpId,
		GrpLevel3Name AS ProductOrGrpName,
		MinAmount, MinSku, MinQty, Pack
		FROM Promotion JOIN GrpLevel3 ON ProductOrGrpId = GrpLevel3Id
		WHERE PromotionType = 'accu-l1' AND
		((StartDate <= '$from_date_sql' AND EndDate >= '$from_date_sql') 
		OR (StartDate <= '$to_date_sql' AND EndDate >= '$to_date_sql')
		OR (StartDate >= '$from_date_sql' AND EndDate <= '$to_date_sql'))
		
		UNION
		
		SELECT PromotionId AS id, PromotionGroup, PromotionId, 
		StartDate, EndDate, PromotionType, ProductOrGrpId,
		'' AS ProductOrGrpName,
		MinAmount, MinSku, MinQty, Pack
		FROM Promotion
		WHERE (PromotionType = 'group' OR PromotionType = 'bill' OR PromotionType = 'accu-all')
		AND ((StartDate <= '$from_date_sql' AND EndDate >= '$from_date_sql') 
		OR (StartDate <= '$to_date_sql' AND EndDate >= '$to_date_sql')
		OR (StartDate >= '$from_date_sql' AND EndDate <= '$to_date_sql'))

		ORDER BY PromotionGroup, ProductOrGrpId, MinAmount, MinSku, MinQty
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
           	 	 'PromotionGroup', 'PromotionId', 'StartDate', 'EndDate',
           	 	 'PromotionType', 'ProductOrGrpId'
        		),
    		),
    		'pagination'=>array(
        		'pageSize'=>10,
    		),
		));

		$model2 = new ProductGrp;

		if (isset($_POST['ajax']))
			$this->performAjaxValidation($model2, 'insert-form2');

		if (isset($_POST['ProductGrp'])) {
			$model2->setAttributes($_POST['ProductGrp']);
			$model2->UpdateAt = date("Y-m-d H:i:s");
			if ($model2->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
			}
		}

		$sql = <<<SQL
		SELECT ProductGrpId AS id, ProductGrpId, P.ProductId, P.ProductName
		FROM ProductGrp JOIN Product P USING(ProductId)
		ORDER BY ProductGrpId, ProductName
SQL;
		// Create filter model and set properties
		$filtersForm2 = new FiltersForm;
		if (isset($_GET['FiltersForm']))
		    $filtersForm2->filters=$_GET['FiltersForm'];
		 
		// Get rawData and create dataProvider
		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		$filteredData = $filtersForm2->filter($rawData);
		$dataProvider2 = new CArrayDataProvider($filteredData, array(
    		'sort'=>array(
        		'attributes'=>array(
           	 	 'ProductGrpId', 'ProductId', 'ProductName',
        		),
    		),
    		'pagination'=>array(
        		'pageSize'=>10,
    		),
		));

		$model3 = new FreeGrp;

		if (isset($_POST['ajax']))
			$this->performAjaxValidation($model3, 'insert-form3');

		if (isset($_POST['FreeGrp'])) {
			$model3->setAttributes($_POST['FreeGrp']);
			$model3->UpdateAt = date("Y-m-d H:i:s");
			if ($model3->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
			}
		}

		$sql = <<<SQL
		SELECT FreeGrpId AS id, FreeGrpId, P.ProductId, P.ProductName, FreePack
		FROM FreeGrp JOIN Product P USING(ProductId)
		ORDER BY FreeGrpId, ProductName
SQL;
		// Create filter model and set properties
		$filtersForm3 = new FiltersForm;
		if (isset($_GET['FiltersForm']))
		    $filtersForm3->filters=$_GET['FiltersForm'];
		 
		// Get rawData and create dataProvider
		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		$filteredData = $filtersForm3->filter($rawData);
		$dataProvider3 = new CArrayDataProvider($filteredData, array(
    		'sort'=>array(
        		'attributes'=>array(
           	 	 'FreeGrpId', 'ProductId', 'ProductName', 'FreePack',
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
    		'from_date' => $from_date,
    		'to_date' => $to_date,
    		'filtersForm2' => $filtersForm2,
    		'dataProvider2' => $dataProvider2,
    		'model2' => $model2,
    		'filtersForm3' => $filtersForm3,
    		'dataProvider3' => $dataProvider3,
    		'model3' => $model3,
		));
	}

	public function actionDeleteProductGroup($id, $productId) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			ProductGrp::model()->findByPk(array('ProductGrpId'=>$id,'ProductId'=>$productId))->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('index'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionDeleteFreeGroup($id, $productId) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			FreeGrp::model()->findByPk(array('FreeGrpId'=>$id,'ProductId'=>$productId))->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('index'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}
}