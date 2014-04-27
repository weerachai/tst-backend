<?php

class SaleAreaController extends GxController {

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
			'model' => $this->loadModel($id, 'SaleArea'),
		));
	}

	public function actionCreate() {
		$model = new SaleArea;

		$this->performAjaxValidation($model, 'sale-area-form');

		if (isset($_POST['SaleArea'])) {
			$model->setAttributes($_POST['SaleArea']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->AreaId));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'SaleArea');

		$this->performAjaxValidation($model, 'sale-area-form');

		if (isset($_POST['SaleArea'])) {
			$model->setAttributes($_POST['SaleArea']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->AreaId));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'SaleArea')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('index'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$sql = <<<SQL
		SELECT AreaId AS id, AreaId, AreaName, 
		SupervisorId, CONCAT(FirstName,' ',LastName) AS Name
		FROM SaleArea LEFT JOIN Employee ON SupervisorId = EmployeeId
		ORDER BY AreaId
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
           	 	 'AreaId', 'AreaName', 'Name'
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