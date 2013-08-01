<?php

Yii::import('application.models._base.BaseCustomer');

class Customer extends BaseCustomer
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'saleUnit' => array(self::BELONGS_TO, 'SaleUnit', 'SaleId'),
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
		$data = Location::model()->getSubDistricts($this->Province,$this->District);
		if (empty($this->SubDistrict))
			$this->SubDistrict = array_shift(array_values($data));
		return $data;
	}

	public function getZipCodes() {
		return Location::model()->getZipCodes($this->Province,$this->District,$this->SubDistrict);
	}
}