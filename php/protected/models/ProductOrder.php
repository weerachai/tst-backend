<?php

Yii::import('application.models._base.BaseProductOrder');

class ProductOrder extends BaseProductOrder
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'saleUnit' => array(self::BELONGS_TO, 'SaleUnit', 'SaleId'),
			'customer' => array(self::BELONGS_TO, 'Customer', 'CustomerId'),
			'orderDetails' => array(self::HAS_MANY, 'OrderDetail', 'OrderNo'),
			'discDetails' => array(self::HAS_MANY, 'DiscDetail', 'OrderNo'),
			'freeDetails' => array(self::HAS_MANY, 'FreeDetail', 'OrderNo'),
		);
	}
}