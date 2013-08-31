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
			'Vat' => Yii::t('app', 'การคิด vat'),
			'ExchangeDiff' => Yii::t('app', 'ส่วนต่างแลกเปลี่ยนสินค้า'),
			'ExchangePaymentMethod' => Yii::t('app', 'วิธีเก็บส่วนต่างแลกเปลี่ยนสินค้า'),
		);
	}

	public function rules() {
		return array(
			array('DayToClear, Vat, OverStock, ExchangeDiff, ExchangePaymentMethod', 'required'),
			array('DayToClear', 'numerical', 'integerOnly'=>true, 'min'=>60),
			array('ExchangeDiff', 'numerical', 'integerOnly'=>true, 'min'=>0),
		);
	}

}