<?php

class ConfigController extends GxController
{
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
			if ($model->DayToClear != $_POST['Config']['DayToClear']) {
				$now = date("Y-m-d H:i:s");
				$sql = "UPDATE DeviceSetting SET DayToClear = " . $_POST['Config']['DayToClear'] . ", UpdateAt = '$now'";
				Yii::app()->db->createCommand($sql)->execute();
			}
			$model->setAttributes($_POST['Config']);

			if ($model->save()) {
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