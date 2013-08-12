<?php

class StockIRController extends GxController {

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
				'actions'=>array('minicreate', 'create', 'update', 'admin', 'delete', 'deliver', 'ajaxupdate'),
				'users'=>array('admin'),
				),
			array('deny', 
				'users'=>array('*'),
				),
			);
}

	public function actionView($id) {
		$sql = <<<SQL
		SELECT RequestNo AS id, RequestDate, SaleName
		FROM StockRequest R JOIN SaleUnit S USING(SaleId)
		WHERE RequestNo IN 
		(SELECT RequestNo FROM RequestIR WHERE IRNo = '$id')
		ORDER BY RequestDate, id
SQL;

		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		$dataProvider1 = new CArrayDataProvider($rawData, array(
    		'sort'=>array(
        		'attributes'=>array(
           	 	 'id', 'RequestDate', 'SaleName',
        		),
    		),
    		'pagination'=>array(
        		'pageSize'=>10,
    		),
		));

		$sql = <<<SQL
		SELECT T.ProductId AS id, IRNo, ProductName,
		SUM(T.QtyLevel1) AS ReqQty1, PackLevel1, 
		SUM(T.QtyLevel2) AS ReqQty2, PackLevel2,
		SUM(T.QtyLevel3) AS ReqQty3, PackLevel3,
		SUM(T.QtyLevel4) AS ReqQty4, PackLevel4,
		D.QtyLevel1 AS Qty1, D.QtyLevel2 AS Qty2,
		D.QtyLevel3 AS Qty3, D.QtyLevel4 AS Qty4		
		FROM (RequestDetail T JOIN Product USING(ProductId))
			JOIN IRDetail D USING(ProductId)
		WHERE IRNo = '$id' AND RequestNo IN 
		(SELECT RequestNo FROM RequestIR WHERE IRNo = '$id')
		GROUP BY id, ProductName, PackLevel1, PackLevel2,
		PackLevel3, PackLevel4, Qty1, Qty2, Qty3, Qty4
		ORDER BY ProductName
SQL;

		// Get rawData and create dataProvider
		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		$dataProvider2 = new CArrayDataProvider($rawData, array(
    		'sort'=>array(
        		'attributes'=>array(
           	 	 'id','ProductName',
        		),
    		),
    		// 'pagination'=>array(
      //   		'pageSize'=>2,
    		// ),
		));

		// Render
		$this->render('view', array(
    		'id' => $id,
    		'dataProvider1' => $dataProvider1,
    		'dataProvider2' => $dataProvider2,
		));
	}

	public function actionCreate() {
		$from_date = isset($_POST['from_date'])? $_POST['from_date'] : '';
		$to_date = isset($_POST['to_date']) ? $_POST['to_date'] : '';
		$saleId = isset($_POST['saleId']) ? $_POST['saleId'] : '';
		$flag = isset($_POST['flag']) ? $_POST['flag'] : '';

		$from_date_sql = empty($from_date) ? '2000-01-01' : $from_date;
		$to_date_sql = empty($to_date) ? '2099-12-31' : $to_date;
		$saleId = empty($saleId) ? '%' : $saleId;
		$flag = empty($flag) ? '%' : $flag;

		$sql = <<<SQL
		SELECT RequestNo AS id, RequestDate, SaleName
		FROM StockRequest R JOIN SaleUnit S USING(SaleId)
		WHERE RequestDate >= '$from_date_sql' AND RequestDate <= '$to_date_sql'
		AND S.SaleId LIKE '$saleId' AND RequestFlag LIKE '$flag'
		AND RequestNo NOT IN (SELECT RequestNo FROM RequestIR)
		ORDER BY RequestDate, id
SQL;

		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		if (isset($_POST['create'])) {
			$IR = new StockIR;
			$IR->IRNo = $IRNo = ControlNo::model()->getControlNo($saleId,'IR');
			$IR->SaleId = $saleId;
			$IR->IRDate = date("Y-m-d");
			$IR->UpdateAt = date("Y-m-d H:i:s");
			if ($IR->save()) {
				ControlNo::model()->updateControlNo($saleId,'IR');
				foreach ($rawData as $row) {
					$rec = new RequestIR;
					$rec->IRNo = $IRNo;
					$rec->RequestNo = $row['id'];
					$rec->UpdateAt = date("Y-m-d H:i:s");
					$rec->save();
				}
				$sql = <<<SQL
				SELECT ProductId,
				SUM(QtyLevel1) AS QtyLevel1, 
				SUM(QtyLevel2) AS QtyLevel2,
				SUM(QtyLevel3) AS QtyLevel3,
				SUM(QtyLevel4) AS QtyLevel4
				FROM RequestDetail
				WHERE RequestNo IN 
				(SELECT RequestNo FROM RequestIR WHERE IRNo = '$IRNo')
				GROUP BY ProductId
SQL;
				$rawData = Yii::app()->db->createCommand($sql)->queryAll();
				foreach ($rawData as $row) {
					$product = Product::model()->find($row['ProductId']);
					$rec = new IRDetail;
					$rec->IRNo = $IRNo;
					$rec->ProductId = $row['ProductId'];
					$rec->QtyLevel1 = $row['QtyLevel1'];
					$rec->QtyLevel2 = $row['QtyLevel2'];
					$rec->QtyLevel3 = $row['QtyLevel3'];
					$rec->QtyLevel4 = $row['QtyLevel4'];
					$rec->PriceLevel1 = $product->PriceLevel1;
					$rec->PriceLevel2 = $product->PriceLevel2;
					$rec->PriceLevel3 = $product->PriceLevel3;
					$rec->PriceLevel4 = $product->PriceLevel4;
					$rec->UpdateAt = date("Y-m-d H:i:s");
					$rec->save();
				}
				$this->redirect(array('view', 'id' => $IRNo));
			}
		}
				// Create filter model and set properties
		$filtersForm = new FiltersForm;
		if (isset($_GET['FiltersForm']))
		    $filtersForm->filters=$_GET['FiltersForm'];
		 
		// Get rawData and create dataProvider
		$filteredData = $filtersForm->filter($rawData);
		$dataProvider = new CArrayDataProvider($filteredData, array(
    		'sort'=>array(
        		'attributes'=>array(
           	 	 'id', 'RequestDate', 'SaleName',
        		),
    		),
    		'pagination'=>array(
        		'pageSize'=>10,
    		),
		));

		// Render
		$this->render('create', array(
    		'filtersForm' => $filtersForm,
    		'dataProvider' => $dataProvider,
    		'from_date' => $from_date,
    		'to_date' => $to_date,
    		'saleId' => $saleId,
			'flag' => $flag,
			'ok' => !empty($rawData)&&$saleId!='%',
		));
	}

	public function actionUpdate($id, $productId) {
		$model = IRDetail::model()->findByPk(array('IRNo'=>$id,'ProductId'=>$productId));

		$this->performAjaxValidation($model, 'stock-form');

		if (isset($_POST['IRDetail'])) {
			$model->setAttributes($_POST['IRDetail']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->IRNo));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$model = $this->loadModel($id, 'StockIR');
			foreach ($model->requestIRs as $request)
				$request->delete();
			foreach ($model->IRdetails as $detail)
				$detail->delete();
			$model->delete();
			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('StockIR');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$sql = <<<SQL
		SELECT IRNo AS id, IRDate, COUNT(RequestNo) AS Num
		FROM StockIR JOIN RequestIR USING(IRNo)
		GROUP BY id, IRDate
		ORDER BY IRDate, id
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
           	 	 'id', 'IRDate', 'Num'
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

	public function actionDeliver($id) {
		$request = $this->loadModel($id, 'StockRequest');
		$model = StockDeliver::model()->find("RequestNo='$request->RequestNo'");
		if ($model == null) {
			$model = new StockDeliver;
			$model->SaleId = $request->SaleId;
			$model->RequestNo = $request->RequestNo;
			$model->DeliverDate = date("Y-m-d");
			$model->DeliverNo = ControlNo::model()->getControlNo($model->SaleId,'ใบส่งสินค้า');
			if ($model->save()) {
				ControlNo::model()->updateControlNo($model->SaleId,'ใบส่งสินค้า');
				foreach ($request->requestDetails as $detail) {
					$rec = new DeliverDetail;
					$rec->DeliverNo = $model->DeliverNo;
					$rec->ProductId = $detail->ProductId;
					$rec->QtyLevel1 = $detail->QtyLevel1;
					$rec->QtyLevel2 = $detail->QtyLevel2;
					$rec->QtyLevel3 = $detail->QtyLevel3;
					$rec->QtyLevel4 = $detail->QtyLevel4;
					$rec->PriceLevel1 = $detail->PriceLevel1;
					$rec->PriceLevel2 = $detail->PriceLevel2;
					$rec->PriceLevel3 = $detail->PriceLevel3;
					$rec->PriceLevel4 = $detail->PriceLevel4;
					$rec->save();
				}
			}
		}

		$this->redirect(array('stockDeliver/update', 'id' => $model->DeliverNo));
	}

	public function actionAjaxupdate($id)
	{
		foreach ($_POST['Qty'] as $productId => $qty) {
			$model = IRDetail::model()->findByPk(array("IRNo"=>$id,"ProductId"=>$productId));
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