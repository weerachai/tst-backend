<?php

Yii::import('application.models._base.BaseSaleArea');

class SaleArea extends BaseSaleArea
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
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