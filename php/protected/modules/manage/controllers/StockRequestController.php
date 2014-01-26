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
			if (!empty($model->stockRequest->UpdateAt))
				throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));

			$model->setAttributes($_POST['RequestDetail']);
//			$model->UpdateAt = date("Y-m-d H:i:s");
			if ($model->save()) {
				$model->stockRequest->updateTotal();
				$model->stockRequest->save();
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
		QtyLevel3, PackLevel3, QtyLevel4, PackLevel4, T.UpdateAt
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

		$rec = StockRequest::model()->findByPk($id);
		$viewonly = !empty($rec->UpdateAt);

		// Render
		$this->render('view', array(
    		'filtersForm' => $filtersForm,
    		'dataProvider' => $dataProvider,
    		'id' => $id,
    		'model' => $model,
    		'viewonly' => $viewonly,
		));
	}

	public function actionCreate() {
		$model = new StockRequest;

		$this->performAjaxValidation($model, 'stock-request-form');

		if (isset($_POST['StockRequest'])) {
			$model->setAttributes($_POST['StockRequest']);
			$model->Status = 'อยู่ระหว่างบันทึก';
			$model->UpdateTotal();
			if ($model->save()) {
				ControlNo::model()->updateControlNo($model->SaleId,'ใบเบิกสินค้า');
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id'=>$model->RequestNo));
			}
		} else {
			$model->SaleId = array_shift(array_keys(SaleUnit::model()->getStockSaleOptions()));
			$model->RequestNo = empty($model->SaleId)?'':ControlNo::model()->getControlNo($model->SaleId,'ใบเบิกสินค้า');
			$model->RequestDate = date("Y-m-d");
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id, $productId) {
		$model = RequestDetail::model()->findByPk(array('RequestNo'=>$id,'ProductId'=>$productId));
		if (!empty($model->stockRequest->UpdateAt))
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));

		$this->performAjaxValidation($model, 'stock-form');

		if (isset($_POST['RequestDetail'])) {
			$model->setAttributes($_POST['RequestDetail']);

			if ($model->save()) {
				$model->stockRequest->updateTotal();
				$model->stockRequest->save();
				$this->redirect(array('view', 'id' => $model->RequestNo));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$model = $this->loadModel($id, 'StockRequest');
			if (!empty($model->UpdateAt))
				throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
			$model->delete();
			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionDeleteDetail($id, $productId) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$model = $this->loadModel($id, 'StockRequest');
			if (!empty($model->UpdateAt))
				throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
			
			$sql = <<<SQL
			DELETE FROM RequestDetail
			WHERE RequestNo = '$id'
			AND ProductId = '$productId'
SQL;
			Yii::app()->db->createCommand($sql)->execute();
			$model = $this->loadModel($id, 'StockRequest');
			$model->updateTotal();
			$model->save();
			$this->redirect(array('view','id'=>$id));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionCopy($id) {
		$old = $this->loadModel($id, 'StockRequest');
		$model = new StockRequest;
		$model->SaleId = $old->SaleId;
		$model->Total = $old->Total;

		$this->performAjaxValidation($model, 'stock-request-form');

		if (isset($_POST['StockRequest'])) {
			$model->setAttributes($_POST['StockRequest']);
			$model->Status = 'อยู่ระหว่างบันทึก';
			$model->UpdateAt = '';
			if ($model->save()) {
				ControlNo::model()->updateControlNo($model->SaleId,'ใบเบิกสินค้า');
				foreach ($old->requestDetails as $detail) {
					$rec = new RequestDetail;
					$rec->attributes = $detail->attributes;
					$rec->RequestNo = $model->RequestNo;
					$rec->UpdateAt = '';
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

		$this->render('copy', array( 'model' => $model, 'id' => $id));
	}

	public function actionAdmin() {
		$sql = <<<SQL
		SELECT RequestNo AS id, RequestType, RequestFlag,
		RequestDate, UpdateAt
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

	public function actionConfirm($id) {
		$model = StockRequest::model()->findByPk($id);
		$t = date("Y-m-d H:i:s");
		foreach ($model->requestDetails as $detail) {
			$detail->UpdateAt = $t;
			$model->Status = 'ยืนยัน';
			$detail->save();
		}
		$model->Status = 'ยืนยัน';
		$model->UpdateAt = $t;
		$model->save();
		$this->redirect(array('admin'));
	}

}