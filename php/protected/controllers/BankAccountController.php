<?php

class BankAccountController extends GxController {

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
			'model' => $this->loadModel($id, 'BankAccount'),
		));
	}

	public function actionCreate() {
		$model = new BankAccount;

		$this->performAjaxValidation($model, 'bank-account-form');

		if (isset($_POST['BankAccount'])) {
			$model->setAttributes($_POST['BankAccount']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->BankId));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'BankAccount');

		$this->performAjaxValidation($model, 'bank-account-form');

		if (isset($_POST['BankAccount'])) {
			$model->setAttributes($_POST['BankAccount']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->BankId));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'BankAccount')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('BankAccount');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new BankAccount('search');
		$model->unsetAttributes();

		if (isset($_GET['BankAccount']))
			$model->setAttributes($_GET['BankAccount']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}