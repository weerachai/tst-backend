<?php

Yii::import('application.models._base.BaseStockRequest');

class StockRequest extends BaseStockRequest
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'requestDetails' => array(self::HAS_MANY, 'RequestDetail', 'RequestNo'),
			'deliver' => array(self::HAS_ONE, 'StockDeliver', 'RequestNo'),
		);
	}

	private $id;
}