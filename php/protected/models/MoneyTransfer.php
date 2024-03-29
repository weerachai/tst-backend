<?php

Yii::import('application.models._base.BaseMoneyTransfer');

class MoneyTransfer extends BaseMoneyTransfer
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'saleUnit' => array(self::BELONGS_TO, 'SaleUnit', 'SaleId'),
		);
	}
}