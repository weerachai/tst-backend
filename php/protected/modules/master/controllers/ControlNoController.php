<?php

class ControlNoController extends GxController
{
	public function filters() {
		return array(
				'accessControl', 
				);
	}

	public function accessRules() {
		return array(
				array('allow', 
					'actions'=>array('index','update'),
					'users'=>array('admin'),
					),
				array('deny', 
					'users'=>array('*'),
					),
				);
	}

	public function actionIndex() {
		$sql = <<<SQL
		SELECT SaleId AS id, SaleId, SaleName, 
		ControlId, ControlName, Prefix, DeviceId, 
		Year, Month, No
		FROM ((ControlNo JOIN SaleUnit USING(SaleId))
		JOIN ControlRunning USING(ControlId))
		JOIN Device USING(SaleId)
		ORDER BY SaleId, ControlId
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
           	 	 'SaleId', 'SaleName',
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

	public function actionUpdate($SaleId, $ControlId) {
		$model = ControlNo::model()->findByPk(array('SaleId'=>$SaleId,'ControlId'=>$ControlId));

		$this->performAjaxValidation($model, 'control-no-form');

		if (isset($_POST['ControlNo'])) {
			$model->setAttributes($_POST['ControlNo']);
			$model->UpdateAt = date("Y-m-d H:i:s");

			if ($model->save()) {
				$this->redirect(array('index'));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

}