<?php

Yii::import('application.models._base.BaseRequestIR');

class RequestIR extends BaseRequestIR
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'stockIR' => array(self::BELONGS_TO, 'StockIR', 'IRNo'),
		);
	}
}