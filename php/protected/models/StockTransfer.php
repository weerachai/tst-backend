<?php

Yii::import('application.models._base.BaseStockTransfer');

class StockTransfer extends BaseStockTransfer
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'saleUnit' => array(self::BELONGS_TO, 'SaleUnit', 'SaleId'),
			'transferDetails' => array(self::HAS_MANY, 'TransferDetail', 'TransferNo'),
		);
	}
}