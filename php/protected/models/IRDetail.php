<?php

Yii::import('application.models._base.BaseIRDetail');

class IRDetail extends BaseIRDetail
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'product' => array(self::BELONGS_TO, 'Product', 'ProductId'),
			'stockIR' => array(self::BELONGS_TO, 'StockIR', 'IRNo'),
		);
	}
}