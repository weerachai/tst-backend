<?php

Yii::import('application.models._base.BaseProductReturn');

class ProductReturn extends BaseProductReturn
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'saleUnit' => array(self::BELONGS_TO, 'SaleUnit', 'SaleId'),
			'customer' => array(self::BELONGS_TO, 'Customer', 'CustomerId'),
			'returnDetails' => array(self::HAS_MANY, 'ReturnDetail', 'ReturnNo'),
		);
	}
}