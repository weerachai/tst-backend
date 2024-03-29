<?php

Yii::import('application.models._base.BaseConfig');

class Config extends BaseConfig
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function attributeLabels() {
		return array(
			'DayToClear' => Yii::t('app', 'จำนวนวันเก็บข้อมูลบน Device'),
			'VatPercent' => Yii::t('app', 'ค่า vat'),
			'Vat' => Yii::t('app', 'การคิด vat'),
			'OverStock' => Yii::t('app', 'ขายเกินจำนวนสต็อค'),
			'ExchangeDiff' => Yii::t('app', 'ส่วนต่างแลกเปลี่ยนสินค้า'),
			'ExchangePaymentMethod' => Yii::t('app', 'วิธีเก็บส่วนต่างแลกเปลี่ยนสินค้า'),
		);
	}

	public function rules() {
		return array(
			array('DayToClear, VatPercent, Vat, OverStock, ExchangeDiff, ExchangePaymentMethod', 'required'),
			array('DayToClear', 'numerical', 'integerOnly'=>true, 'min'=>60),
			array('VatPercent', 'numerical', 'min'=>0),
			array('ExchangeDiff', 'numerical', 'integerOnly'=>true, 'min'=>0),
		);
	}

}