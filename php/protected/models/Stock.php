<?php

Yii::import('application.models._base.BaseStock');

class Stock extends BaseStock
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'saleUnit' => array(self::BELONGS_TO, 'SaleUnit', 'SaleId'),
			'product' => array(self::BELONGS_TO, 'Product', 'ProductId'),
		);
	}
}