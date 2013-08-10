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
				'actions'=>array('minicreate', 'create', 'update', 'admin', 'delete'),
				'users'=>array('admin'),
				),
			array('deny', 
				'users'=>array('*'),
				),
			);
}

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'StockDeliver'),
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
		$model = $this->loadModel($id, 'StockDeliver');

		$this->performAjaxValidation($model, 'stock-deliver-form');

		if (isset($_POST['StockDeliver'])) {
			$model->setAttributes($_POST['StockDeliver']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->DeliverNo));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'StockDeliver')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
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
		$model = new StockDeliver('search');
		$model->unsetAttributes();

		if (isset($_GET['StockDeliver']))
			$model->setAttributes($_GET['StockDeliver']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}