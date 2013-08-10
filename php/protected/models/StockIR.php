<?php

Yii::import('application.models._base.BaseStockIR');

class StockIR extends BaseStockIR
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'requestIRs' => array(self::HAS_MANY, 'RequestIR', 'IRNo'),
			'IRdetails' => array(self::HAS_MANY, 'IRDetail', 'IRNo'),
		);
	}
}