<?php

class SaleAreaController extends GxController {

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
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('SaleArea');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new SaleArea('search');
		$model->unsetAttributes();

		if (isset($_GET['SaleArea']))
			$model->setAttributes($_GET['SaleArea']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}