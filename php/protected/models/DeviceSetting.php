<?php

Yii::import('application.models._base.BaseDeviceSetting');

class DeviceSetting extends BaseDeviceSetting
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