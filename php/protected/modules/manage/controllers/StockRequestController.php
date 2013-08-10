<?php

class StockRequestController extends GxController {

public function filters() {
	return array(
			'accessControl', 
			);
}

public function accessRules() {
	return array(
			array('allow', 
				'actions'=>array(),
				'users'=>array('@'),
				),
			array('allow', 
				'actions'=>array('minicreate', 'create', 'update', 'admin', 'delete', 'copy', 'view'),
				'users'=>array('admin'),
				),
			array('deny', 
				'users'=>array('*'),
				),
			);
}

	public function actionView($id) {
		$model = new RequestDetail;
		$model->RequestNo = $id;

		$this->performAjaxValidation($model, 'stock-form');

		if (isset($_POST['RequestDetail'])) {
			$model->setAttributes($_POST['RequestDetail']);
			$model->UpdateAt = date("Y-m-d H:i:s");
			if ($model->save()) {
				$model = new RequestDetail;
				$model->RequestNo = $id;
			}
		}
		if (empty($model->ProductId)) {
			$model->ProductId = array_shift(array_keys(RequestDetail::model()->getProduct($id,'','','','')));
			$model->PriceLevel1 = $model->product->PriceLevel1;
			$model->PriceLevel2 = $model->product->PriceLevel2;
			$model->PriceLevel3 = $model->product->PriceLevel3;
			$model->PriceLevel4 = $model->product->PriceLevel4;
		}

		$sql = <<<SQL
		SELECT T.ProductId AS id, RequestNo, ProductName,
		QtyLevel1, PackLevel1, QtyLevel2, PackLevel2,
		QtyLevel3, PackLevel3, QtyLevel4, PackLevel4
		FROM RequestDetail T JOIN Product USING(ProductId) 
		WHERE RequestNo = '$id'
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
    		'model' => $model,
		));
	}

	public function actionCreate() {
		$model = new StockRequest;

		$this->performAjaxValidation($model, 'stock-request-form');

		if (isset($_POST['StockRequest'])) {
			$model->setAttributes($_POST['StockRequest']);
			$model->UpdateAt = date("Y-m-d H:i:s");
			if ($model->save()) {
				ControlNo::model()->updateControlNo($model->SaleId,'ใบเบิกสินค้า');
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id'=>$model->RequestNo));
			}
		} else {
			$model->SaleId = array_shift(array_keys(SaleUnit::model()->getAssigendOptions()));
			$model->RequestNo = ControlNo::model()->getControlNo($model->SaleId,'ใบเบิกสินค้า');
			$model->RequestDate = date("Y-m-d");
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id, $productId) {
		$model = RequestDetail::model()->findByPk(array('RequestNo'=>$id,'ProductId'=>$productId));

		$this->performAjaxValidation($model, 'stock-form');

		if (isset($_POST['RequestDetail'])) {
			$model->setAttributes($_POST['RequestDetail']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->RequestNo));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id, $productId) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$sql = <<<SQL
			DELETE FROM RequestDetail
			WHERE RequestNo = '$id'
			AND ProductId = '$productId'
SQL;
			Yii::app()->db->createCommand($sql)->execute();
			$this->redirect(array('view','id'=>$id));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionCopy($id) {
		$old = $this->loadModel($id, 'StockRequest');
		$model = new StockRequest;
		$model->SaleId = $old->SaleId;

		$this->performAjaxValidation($model, 'stock-request-form');

		if (isset($_POST['StockRequest'])) {
			$model->setAttributes($_POST['StockRequest']);
			$model->UpdateAt = date("Y-m-d H:i:s");
			if ($model->save()) {
				ControlNo::model()->updateControlNo($model->SaleId,'ใบเบิกสินค้า');
				foreach ($old->requestDetails as $detail) {
					$rec = new RequestDetail;
					$rec->attributes = $detail->attributes;
					$rec->RequestNo = $model->RequestNo;
					$rec->save();
				}
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('admin'));
			}
		} else {
			$model->RequestNo = ControlNo::model()->getControlNo($model->SaleId,'ใบเบิกสินค้า');
			$model->RequestDate = date("Y-m-d");
		}

		$this->render('copy', array( 'model' => $model));
	}

	public function actionAdmin() {
		$sql = <<<SQL
		SELECT RequestNo AS id, RequestType, RequestFlag,
		RequestDate
		FROM StockRequest
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
           	 	 'id', 'RequestType', 'RequestFlag', 'RequestDate'
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

}