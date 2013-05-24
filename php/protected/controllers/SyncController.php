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

	public function actionLogin() {
		header('Content-type: application/json');
		if(isset($_POST['UserId']) && isset($_POST['Password'])) {
			$model = User::model()->findByAttributes(array(
				'UserId'=>$_POST['UserId'],
				'SaleFlag'=>'Y',
				'Status'=>'active',
				));
			if($model == null) {
				$response["success"] = 0;
				$response["message"] = "Incorrect User ID";
			} else {
				$bcrypt = new bCrypt();	
				if ($bcrypt->verify($_POST['Password'], $model->Password)) {
					if (isset($_POST['User'])) {
						if (!empty($model->DeviceId) && $model->DeviceId != $_POST['User']['DeviceId']) {
							$response["success"] = 0;
							$response["message"] = "This user is locked to another device";
						} else {
							$model->attributes=$_POST['User'];
							if($model->save()) {
								$response["success"] = 1;
								$response["SaleType"] = $model->SaleType;
								$response["CustomerNo"] = $model->CustomerNo;
								$response["OrderNo"] = $model->OrderNo;
								$response["ReturnNo"] = $model->ReturnNo;
								$response["UpdateAt"] = $model->UpdateAt;
								$response["message"] = "Device ID updated";
								$tables = array("StockCheck", "ProductOrder", 
									"OrderDetail", "ProductReturn", "ReturnDetail", 
									"FreeDetail", "DiscDetail");
								foreach ($tables as $table) {
									$rows = $table::model()->findAllByAttributes(array('SaleId'=>$_POST['UserId']),
														array('order'=>'id DESC'));
									if ($rows != null)
										$response[$table] = $rows[0]->id;
									else
										$response[$table] = 0;
								}
							} else {
								$response["success"] = 0;
								$response["message"] = "Error Saving Device ID";
							}
						}
					} else {
						$response["success"] = 0;
						$response["message"] = "No Device ID";
					}
				} else {
					$response["success"] = 0;
					$response["message"] = "Incorrect Password";
				}
			} 
		} else {
			$response["success"] = 0;
			$response["message"] = "Missing parameters.";
		}
		echo json_encode($response);
		Yii::app()->end();	
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
		$model = $table::model()->findByPk($pk);
		if ($model == null)
			$model = new $table;
		$model->attributes = $params['params'];
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