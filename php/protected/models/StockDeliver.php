<?php

Yii::import('application.models._base.BaseStockDeliver');

class StockDeliver extends BaseStockDeliver
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'request' => array(self::BELONGS_TO, 'StockRequest', 'RequestNo'),
		);
	}
}