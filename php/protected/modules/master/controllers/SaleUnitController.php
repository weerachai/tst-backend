<?php

class SaleUnitController extends GxController {

	public function filters() {
		return array('accessControl');
	}

	public function accessRules() {
		return array(
			array('allow', 
				'actions'=>array('index','view','create','update','delete'),
				'expression' => '$user->checkAccess("operator")', 
			),
			array('deny', 
				'users'=>array('*'),
			),
		);
	}

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'SaleUnit'),
		));
	}

	public function actionCreate() {
		$model = new SaleUnit;

		$this->performAjaxValidation($model, 'sale-unit-form');

		if (isset($_POST['SaleUnit'])) {
			$model->setAttributes($_POST['SaleUnit']);
			if ($model->save()) {
				$model->device = new Device;
				$model->device->SaleId = $model->SaleId;
				$model->device->DeviceId = $_POST['SaleUnit']['DeviceId'];
				$model->device->Username = $_POST['SaleUnit']['Username'];	
				$hash = new myMD5();
				$model->device->Password = $hash->hash($_POST['SaleUnit']['Password']);
 				$model->device->UpdateAt = date("Y-m-d h:i:s");
 				$model->device->save();

 				$config = Config::model()->findByPk(1);
				$model->device = new DeviceSetting;
				$model->device->SaleId = $model->SaleId;
				$model->device->SaleType = $model->SaleType;
				$model->device->Vat = $config->Vat;
				$model->device->OverStock = $config->OverStock;
				$model->device->DayToClear = $config->DayToClear;
				$model->device->ExchangeDiff = $config->ExchangeDiff;
				$model->device->ExchangePaymentMethod = $config->ExchangePaymentMethod;
				
				$model->device->UpdateAt = date("Y-m-d h:i:s");
 				$model->device->save();

 				$running = ControlRunning::model()->findAll();
 				foreach ($running as $row) {
 					$no = new ControlNo;
 					$no->SaleId = $model->SaleId;
 					$no->ControlId = $row->ControlId;
 					$no->Year = date("y");
 					$no->Month = date("n");
 					$no->No = 1;
 					$no->UpdateAt = date("Y-m-d h:i:s");
 					$no->save();
 				}
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->SaleId));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'SaleUnit');

		$this->performAjaxValidation($model, 'sale-unit-form');

		if (isset($_POST['SaleUnit'])) {
			$model->setAttributes($_POST['SaleUnit']);

			if ($model->save()) {
				$model->device->DeviceId = $_POST['SaleUnit']['DeviceId'];
				$model->device->Username = $_POST['SaleUnit']['Username'];	
				if (!empty($_POST['SaleUnit']['Password'])) {
					$hash = new myMD5();
					$model->device->Password = $hash->hash($_POST['SaleUnit']['Password']);
				}
 				$model->device->save();

				$model->deviceSetting->SaleType = $_POST['SaleUnit']['SaleType'];
				$model->deviceSetting->save();

				$this->redirect(array('view', 'id' => $model->SaleId));
			}
		} else {
			$model->DeviceId = $model->device->DeviceId;
			$model->Username = $model->device->Username;
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'SaleUnit')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('index'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$sql = <<<SQL
		SELECT SaleId AS id, SaleId, SaleName, 
		DeviceId, Username, SaleType
		FROM SaleUnit JOIN Device USING(SaleId)
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
           	 	 'SaleId', 'SaleName', 'DeviceId', 'Username', 'SaleType'
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

}