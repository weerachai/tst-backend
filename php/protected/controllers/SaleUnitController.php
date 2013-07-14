<?php

class SaleUnitController extends GxController {

public function filters() {
	return array(
			'accessControl', 
			);
}

public function accessRules() {
	return array(
			array('allow',
				'actions'=>array('index','view'),
				'users'=>array('*'),
				),
			array('allow', 
				'actions'=>array('minicreate', 'create','update'),
				'users'=>array('@'),
				),
			array('allow', 
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
				$this->redirect(array('view', 'id' => $model->SaleId));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'SaleUnit')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('SaleUnit');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new SaleUnit('search');
		$model->unsetAttributes();

		if (isset($_GET['SaleUnit']))
			$model->setAttributes($_GET['SaleUnit']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}