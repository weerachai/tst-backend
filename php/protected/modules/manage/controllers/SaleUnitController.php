<?php

class SaleUnitController extends GxController
{
	public function actionIndex()
	{
		if (isset($_POST['SaleId'])) {
			$model = $this->loadModel($_POST['SaleId'], 'SaleUnit');
			$model->AreaId = $_POST['AreaId'];
			$model->EmployeeId = $_POST['EmployeeId'];
			$model->save();
		}

		$model = new SaleUnit('search');
		$model->unsetAttributes();

		if (isset($_GET['SaleUnit']))
			$model->setAttributes($_GET['SaleUnit']);

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$model = $this->loadModel($id, 'SaleUnit');
			$model->AreaId = null;
			$model->EmployeeId = null;
			$model->save();
			$this->redirect(array('index'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'SaleUnit'),
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