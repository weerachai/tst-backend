<?php

class StockDeliverController extends GxController {

public function filters() {
	return array(
			'accessControl', 
			);
}

public function accessRules() {
	return array(
			array('allow', 
				'actions'=>array('index', 'view'),
				'users'=>array('@'),
				),
			array('allow', 
				'actions'=>array('minicreate', 'create', 'update', 'admin', 'delete', 'ajaxupdate'),
				'users'=>array('admin'),
				),
			array('deny', 
				'users'=>array('*'),
				),
			);
}

	public function actionView($id) {
		$sql = <<<SQL
		SELECT T.ProductId AS id, DeliverNo, ProductName,
		QtyLevel1, PackLevel1, QtyLevel2, PackLevel2,
		QtyLevel3, PackLevel3, QtyLevel4, PackLevel4
		FROM DeliverDetail T JOIN Product USING(ProductId) 
		WHERE DeliverNo = '$id'
		ORDER BY ProductName
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
           	 	 'id','ProductName',
        		),
    		),
    		'pagination'=>array(
        		'pageSize'=>10,
    		),
		));

		// Render
		$this->render('view', array(
    		'filtersForm' => $filtersForm,
    		'dataProvider' => $dataProvider,
    		'id' => $id,
		));
	}

	public function actionCreate() {
		$model = new StockDeliver;

		$this->performAjaxValidation($model, 'stock-deliver-form');

		if (isset($_POST['StockDeliver'])) {
			$model->setAttributes($_POST['StockDeliver']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->DeliverNo));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$sql = <<<SQL
		SELECT D.ProductId AS id, D.DeliverNo AS DeliverNo, ProductName,
		D.QtyLevel1 AS Qty1, PackLevel1, R.QtyLevel1 AS ReqQty1,
		D.QtyLevel2 AS Qty2, PackLevel2, R.QtyLevel2 AS ReqQty2,
		D.QtyLevel3 AS Qty3, PackLevel3, R.QtyLevel3 AS ReqQty3,
		D.QtyLevel4 AS Qty4, PackLevel4, R.QtyLevel4 AS ReqQty4
		FROM ((StockDeliver JOIN DeliverDetail D USING(DeliverNo))
		JOIN Product USING(ProductId))
		JOIN RequestDetail R USING(RequestNo, ProductId) 
		WHERE DeliverNo = '$id'
		ORDER BY ProductName
SQL;

		// Get rawData and create dataProvider
		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		$dataProvider = new CArrayDataProvider($rawData, array(
    		'sort'=>array(
        		'attributes'=>array(
           	 	 'id','ProductName',
        		),
    		),
    		// 'pagination'=>array(
      //   		'pageSize'=>10,
    		// ),
		));

		// Render
		$this->render('update', array(
    		'id' => $id,
    		'dataProvider' => $dataProvider,
		));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			Yii::app()->db->createCommand("DELETE FROM DeliverDetail WHERE DeliverNo = '$id'")->execute();
			Yii::app()->db->createCommand("DELETE FROM StockDeliver WHERE DeliverNo = '$id'")->execute();
			$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('StockDeliver');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$sql = <<<SQL
		SELECT DeliverNo AS id, RequestNo, DeliverDate
		FROM StockDeliver
		ORDER BY id
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
           	 	 'id', 'RequestNo', 'DeliverDate'
        		),
    		),
    		'pagination'=>array(
        		'pageSize'=>10,
    		),
		));

		// Render
		$this->render('admin', array(
    		'filtersForm' => $filtersForm,
    		'dataProvider' => $dataProvider,
		));
	}

	public function actionAjaxupdate($id)
	{
		foreach ($_POST['Qty'] as $productId => $qty) {
			$model = DeliverDetail::model()->findByPk(array("DeliverNo"=>$id,"ProductId"=>$productId));
			if ($model) {
				$model->QtyLevel1 = $qty[1];
				$model->QtyLevel2 = $qty[2];
				$model->QtyLevel3 = $qty[3];
				$model->QtyLevel4 = $qty[4];
				$model->save();
			}
		}
	}

}