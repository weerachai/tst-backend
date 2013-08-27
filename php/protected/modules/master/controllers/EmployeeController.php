<?php

class EmployeeController extends GxController {

	public function filters() {
		return array(
				'accessControl', 
				);
	}

	public function accessRules() {
		return array(
				array('allow', 
					'actions'=>array('index','view','create','update','delete'),
					'users'=>array('admin'),
					),
				array('deny', 
					'users'=>array('*'),
					),
				);
	}

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Employee'),
		));
	}

	public function actionCreate() {
		$model = new Employee;

		$this->performAjaxValidation($model, 'employee-form');

		if (isset($_POST['Employee'])) {
			$model->setAttributes($_POST['Employee']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->EmployeeId));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Employee');

		$this->performAjaxValidation($model, 'employee-form');

		if (isset($_POST['Employee'])) {
			$model->setAttributes($_POST['Employee']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->EmployeeId));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Employee')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('index'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$model = new Employee('search');
		$model->unsetAttributes();

		if (isset($_GET['Employee']))
			$model->setAttributes($_GET['Employee']);

		$this->render('index', array(
			'model' => $model,
		));
	}

}