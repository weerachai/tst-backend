<?php

Yii::import('application.models._base.BaseDevice');

class Device extends BaseDevice
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'saleUnit' => array(self::BELONGS_TO, 'SaleUnit', 'SaleId'),
		);
	}

	public function attributeLabels() {
		return array(
			'DeviceId' => Yii::t('app', 'รหัสอุปกรณ์'),
			'DeviceKey' => Yii::t('app', 'Device Key'),
			'SaleId' => Yii::t('app', 'หน่วยขาย'),
			'Username' => Yii::t('app', 'รหัสผู้ใช้'),
			'Password' => Yii::t('app', 'รหัสผ่าน'),
			'UpdateAt' => Yii::t('app', 'Update At'),
		);
	}
}