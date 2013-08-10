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
		);
	}

	private $id;
}