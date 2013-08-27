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
		);
	}

	public function rules() {
		return array(
			array('DayToClear', 'required'),
			array('DayToClear', 'numerical', 'integerOnly'=>true, 'min'=>60),
		);
	}
}