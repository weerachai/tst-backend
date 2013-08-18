<?php

Yii::import('application.models._base.BaseProductExchange');

class ProductExchange extends BaseProductExchange
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'customer' => array(self::BELONGS_TO, 'Customer', 'CustomerId'),
		);
	}
}