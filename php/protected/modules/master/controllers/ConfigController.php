<?php

class ConfigController extends GxController
{
	public function filters() {
		return array('accessControl');
	}

	public function accessRules() {
		return array(
			array('allow', 
				'actions'=>array('index','update'),
				'expression' => '$user->checkAccess("admin")', 
			),
			array('deny', 
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$this->render('index', array(
			'model' => $this->loadModel(1, 'Config'),
		));
	}

	public function actionUpdate()
	{
		$model = $this->loadModel(1, 'Config');

		$this->performAjaxValidation($model, 'config-form');

		if (isset($_POST['Config'])) {
			$model->setAttributes($_POST['Config']);
			if ($model->save()) {
					
				$now = date("Y-m-d H:i:s");
				$sql = "UPDATE DeviceSetting SET ";
				$sql .= "DayToClear = " . $_POST['Config']['DayToClear'];
				$sql .= ", VatPercent = '" . $_POST['Config']['VatPercent'] . "'";
				$sql .= ", Vat = '" . $_POST['Config']['Vat'] . "'";
				$sql .= ", OverStock = '" . $_POST['Config']['OverStock'] . "'";
				$sql .= ", ExchangeDiff = " . $_POST['Config']['ExchangeDiff'];
				$sql .= ", ExchangePaymentMethod = '" . $_POST['Config']['ExchangePaymentMethod'] . "'";
				$sql .= ", UpdateAt = '$now'";
				Yii::app()->db->createCommand($sql)->execute();

				$this->redirect(array('index'));		
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
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