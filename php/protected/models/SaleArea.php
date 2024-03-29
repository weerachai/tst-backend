<?php

Yii::import('application.models._base.BaseSaleArea');

class SaleArea extends BaseSaleArea
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'supervisor' => array(self::BELONGS_TO, 'Employee', 'SupervisorId'),
			'saleUnits' => array(self::HAS_MANY, 'SaleUnit', 'AreaId'),
		);
	}

	public function attributeLabels() {
		return array(
			'AreaId' => Yii::t('app', 'รหัสพื้นที่ขาย'),
			'AreaName' => Yii::t('app', 'ชื่อพื้นที่ขาย'),
			'SupervisorId' => Yii::t('app', 'Supervisor'),
			'supervisor' => Yii::t('app', 'Supervisor'),
		);
	}

	public function rules() {
		return array(
			array('AreaId, AreaName', 'required'),
            array('AreaId, AreaName', 'unique'),
			array('AreaId, AreaName', 'length', 'max'=>255),
			array('SupervisorId', 'default', 'setOnEmpty' => true, 'value' => null),
//			array('AreaId, AreaName, SupervisorId', 'safe', 'on'=>'search'),
		);
	}

	public function getProvinces() {
		$data = Location::model()->getProvinces();
		if (empty($this->Province))
			$this->Province = array_shift(array_values($data));
		return $data;
	}

	public function getDistricts() {
		$data = Location::model()->getDistricts($this->Province);
		if (empty($this->District))
			$this->District = array_shift(array_values($data));
		return $data;
	}

	public function getSubDistricts() {
		return Location::model()->getDistricts($this->Province,$this->District);
	}

	public static function getOptions() {
		return CHtml::listData(SaleArea::model()->findAll(), 
				'AreaId', 'AreaName'
			);
	}
}