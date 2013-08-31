<?php

class SyncController extends Controller
{
	public function actionLogin() {
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
		$jsonHelper->end("Logged-in successfully.");
	}

	private function saveLog($saleId, $table) {
		$model = SyncLog::model()->find(array(
			'order'=>'id DESC', 
			'condition'=>'SaleId=:SaleId', 
			'params'=>array(':SaleId'=>$saleId),
			));
		if ($model != null && $model->Action == 'รับ' && $model->TableName == $table) {
			$model->NumRecords = $model->NumRecords + 1;
		} else {
			$model = new SyncLog;
			$model->SaleId = $saleId;
			$model->Action = 'รับ';
			$model->TableName = $table;
			$model->NumRecords = 1;
		}
		$model->LogTime = date("Y-m-d H:i:s");
		$model->save();
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
//		file_put_contents("/home/tu/www/backend/php/protected/log.txt", print_r($pk,true), FILE_APPEND | LOCK_EX);
		$model = $table::model()->findByPk($pk);
		if ($model == null)
			$model = new $table;
//		file_put_contents("/home/tu/www/backend/php/protected/log.txt", print_r($model->attributes,true), FILE_APPEND | LOCK_EX);
		$model->attributes = $params['params'];
//		file_put_contents("/home/tu/www/backend/php/protected/log.txt", print_r($model->attributes,true), FILE_APPEND | LOCK_EX);
		$jsonHelper->assertTrue($model->save(),$model->getErrors());
		$this->saveLog($device->SaleId,$table);
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
		$rows1 = array();
		$rows2 = array();
		$rows3 = array();
		foreach($models as $model){
			$rows[] = $model->attributes;
			if ($table == 'ProductOrder') {
				foreach($model->orderDetails as $m)
					$rows1[] = $m->attributes;
				foreach($model->freeDetails as $m)
					$rows2[] = $m->attributes;
				foreach($model->discDetails as $m)
					$rows3[] = $m->attributes;
			} elseif ($table == 'ProductInvoice') {
				foreach($model->invoiceDetails as $m)
					$rows1[] = $m->attributes;
			} elseif ($table == 'ProductReturn') {
				foreach($model->returnDetails as $m)
					$rows1[] = $m->attributes;
			} elseif ($table == 'BillCollection') {
				foreach($model->payments as $m) {
					$rows1[] = $m->attributes;
					foreach ($m->invoicePayments as $p)
						$rows2[] = $p->attributes;
				}
			} elseif ($table == 'ProductExchange') {
				foreach($model->exchangeInDetails as $m)
					$rows1[] = $m->attributes;
				foreach($model->exchangeOutDetails as $m)
					$rows2[] = $m->attributes;
			} elseif ($table == 'StockRequest') {
				foreach($model->requestDetails as $m)
					$rows1[] = $m->attributes;
			} elseif ($table == 'StockDeliver') {
				foreach($model->deliverDetails as $m)
					$rows1[] = $m->attributes;
			} elseif ($table == 'StockReceive') {
				foreach($model->receiveDetails as $m)
					$rows1[] = $m->attributes;
			} elseif ($table == 'StockTransfer') {
				foreach($model->transferDetails as $m)
					$rows1[] = $m->attributes;
			}

		}
		$jsonHelper->setDataRow($table,$rows);
		if ($table == 'ProductOrder') {
			$jsonHelper->setDataRow("OrderDetail",$rows1);
			$jsonHelper->setDataRow("FreeDetail",$rows2);
			$jsonHelper->setDataRow("DiscDetail",$rows3);
		} elseif ($table == 'ProductInvoice') {
			$jsonHelper->setDataRow("InvoiceDetail",$rows1);
		} elseif ($table == 'ProductReturn') {
			$jsonHelper->setDataRow("ReturnDetail",$rows1);
		} elseif ($table == 'BillCollection') {
			$jsonHelper->setDataRow("Payment",$rows1);
			$jsonHelper->setDataRow("InvoicePayment",$rows2);
		} elseif ($table == 'ProductExchange') {
			$jsonHelper->setDataRow("ExchangeInDetail",$rows1);
			$jsonHelper->setDataRow("ExchangeOutDetail",$rows2);
		} elseif ($table == 'StockRequest') {
			$jsonHelper->setDataRow("RequestDetail",$rows1);
		} elseif ($table == 'StockDeliver') {
			$jsonHelper->setDataRow("DeliverDetail",$rows1);
		} elseif ($table == 'StockReceive') {
			$jsonHelper->setDataRow("ReceiveDetail",$rows1);
		} elseif ($table == 'StockTransfer') {
			$jsonHelper->setDataRow("TransferDetail",$rows1);
		}

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