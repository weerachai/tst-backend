<?php

class PromotionController extends GxController {

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
			'model' => $this->loadModel($id, 'Promotion'),
		));
	}

	public function actionCreate() {
		$model = new Promotion;

		$this->performAjaxValidation($model, 'promotion-form');

		if (isset($_POST['Promotion'])) {
			$model->setAttributes($_POST['Promotion']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->PromotionId));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Promotion');

		$this->performAjaxValidation($model, 'promotion-form');

		if (isset($_POST['Promotion'])) {
			$model->setAttributes($_POST['Promotion']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->PromotionId));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Promotion')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Promotion');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Promotion('search');
		$model->unsetAttributes();

		if (isset($_GET['Promotion']))
			$model->setAttributes($_GET['Promotion']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}