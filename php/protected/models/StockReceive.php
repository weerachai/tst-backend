<?php

Yii::import('application.models._base.BaseStockReceive');

class StockReceive extends BaseStockReceive
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'receiveDetails' => array(self::HAS_MANY, 'ReceiveDetail', 'ReceiveNo'),
			'deliver' => array(self::BELONGS_TO, 'StockDeliver', 'DeliverNo'),
			'request' => array(self::BELONGS_TO, 'StockRequest', 'RequestNo'),
		);
	}
}