<?php

Yii::import('application.models._base.BaseReceiveDetail');

class ReceiveDetail extends BaseReceiveDetail
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'product' => array(self::BELONGS_TO, 'Product', 'ProductId'),
			'stockReceive' => array(self::BELONGS_TO, 'StockReceive', 'ReceiveNo'),
		);
	}
}