<?php

class SyncController extends Controller
{
	public function actionRegister() {
		$params = $_POST;
		$jsonHelper = new JSONHelper($params);
		$jsonHelper->assertRequiredParams(array());
		$device = $jsonHelper->login();
		$jsonHelper->assertTrue(empty($device->DeviceKey)||$device->DeviceKey==$params['DeviceKey'],"Account is not available.");
		$setting = DeviceSetting::model()->findByPk($device->SaleId);
		$jsonHelper->assertTrue($setting!=null,"No Device Setting.");

		$device->DeviceKey = $params['DeviceKey'];
		$jsonHelper->assertTrue($device->save(),"Error saving data.");
		$rows[] = $device->attributes;
		$jsonHelper->setDataRow("Device",$rows);
		unset($rows);
		$rows[] = $setting->attributes;
		$jsonHelper->setDataRow("DeviceSetting",$rows);
		$jsonHelper->end("Registered successfully.");
	}

	public function actionSave() 
	{
		$params = $_POST;
		$jsonHelper = new JSONHelper($params);
		$jsonHelper->assertRequiredParams(array("Table"));
		$device = $jsonHelper->login();		
		$jsonHelper->assertTrue($device->DeviceKey==$params['DeviceKey'],"Account is locked to another device.");
		$table = $params['Table'];
		$jsonHelper->assertTrue(($schema = Yii::app()->db->schema->getTable($table)) != null,"Table '$table' does not exist.");
		if (is_array($schema->primaryKey)) {
			$pk = array();
			foreach ($schema->primaryKey as $key)
				$pk[$key] = $params['params'][$key];
		} else {
			$pk = $params['params'][$schema->primaryKey];
		}
//		file_put_contents("/home/tu/www/backend/php/protected/log.txt", print_r($params['params'],true), FILE_APPEND | LOCK_EX);
		$model = $table::model()->findByPk($pk);
		if ($model == null)
			$model = new $table;
//		file_put_contents("/home/tu/www/backend/php/protected/log.txt", print_r($model->attributes,true), FILE_APPEND | LOCK_EX);
		$model->attributes = $params['params'];
//		file_put_contents("/home/tu/www/backend/php/protected/log.txt", print_r($model->attributes,true), FILE_APPEND | LOCK_EX);
		$jsonHelper->assertTrue($model->save(),$model->getErrors());
		$jsonHelper->end("Updated successfully.");
	}

	public function actionSync() 
	{
		$params = $_POST;
		$jsonHelper = new JSONHelper($params);
		$jsonHelper->assertRequiredParams(array("Table","UpdateAt"));
		$device = $jsonHelper->login();		
		$jsonHelper->assertTrue($device->DeviceKey==$params['DeviceKey'],"Account is locked to another device.");
		$table = $params['Table'];
		$jsonHelper->assertTrue(($schema = Yii::app()->db->schema->getTable($table)) != null,"Table '$table' does not exist.");
		$updateAt = $params['UpdateAt'];
		$saleId = $device->SaleId;
		if ($schema->getColumn("SaleId") == null)
			$models = $table::model()->findAll(
				array("condition"=>"UpdateAt > '$updateAt'"));
		else 
			$models = $table::model()->findAll(
				array("condition"=>"UpdateAt > '$updateAt' AND SaleId = '$saleId'"));
		$rows = array();
		foreach($models as $model){
			$rows[] = $model->attributes;
		}
		$jsonHelper->setDataRow($table,$rows);
		$jsonHelper->end("Updated successfully.");
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