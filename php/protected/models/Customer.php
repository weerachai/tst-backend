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
			'productOrders' => array(self::HAS_MANY, 'ProductOrder', 'CustomerId'),
			'productReturns' => array(self::HAS_MANY, 'ProductReturn', 'CustomerId'),
			'productExchanges' => array(self::HAS_MANY, 'ProductExchange', 'CustomerId'),
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

	public static function getAvailableProvinces() {
		$data = Customer::model()->findAll(array(
				'select'=>'Province',
				'distinct'=>true,
				'condition'=>'SaleId IS NULL',
				));
		return CHtml::listData($data,'Province','Province');
	}

	public static function getAvailableDistricts($province) {
		if (empty($province)) {
			$province = array_shift(Customer::model()->getAvailableProvinces());
		}
		if (empty($province))
			return array();
		$data = Customer::model()->findAll(array(
				'select'=>'District',
				'distinct'=>true,
				'condition'=>'SaleId IS NULL AND Province=:Province',
				'params'=>array(':Province'=>$province)
				));
		return array_merge(array(''=>'(ทั้งหมด)'), CHtml::listData($data,'District','District'));
	}

	public static function getAvailableSubDistricts($province,$district) {
		if (empty($province)) {
		 	$province = array_shift(Customer::model()->getAvailableProvinces());
//		 	$district = array_shift(Customer::model()->getAvailableDistricts($province));
		}
		if (empty($province))
			return array();
		$data = Customer::model()->findAll(array(
				'select'=>'SubDistrict',
				'distinct'=>true,
				'condition'=>'SaleId IS NULL AND Province=:Province AND District=:District',
				'params'=>array(':Province'=>$province,':District'=>$district)
				));
		return array_merge(array(''=>'(ทั้งหมด)'), CHtml::listData($data,'SubDistrict','SubDistrict'));
	}

	public static function getSaleProvinces($saleId) {
		if (empty($saleId)) {
			$saleId = array_shift(array_keys(Employee::model()->getAssignedOptions()));
		}
		if (empty($saleId))
		 	return array();
		$data = Customer::model()->findAll(array(
				'select'=>'Province',
				'distinct'=>true,
				'condition'=>"SaleId=:SaleId AND (Trip1 IS NULL OR Trip2 IS NULL OR Trip3 IS NULL OR Trip1 = '' OR Trip2 = '' OR Trip3 = '')",
				'params'=>array(':SaleId'=>$saleId)
				));
		return CHtml::listData($data,'Province','Province');
	}

	public static function getSaleDistricts($saleId, $province) {
		if (empty($saleId)) {
			$saleId = array_shift(array_keys(Employee::model()->getAssignedOptions()));
		}
		if (empty($saleId))
			return array();
		if (empty($province)) {
			$province = array_shift(Customer::model()->getSaleProvinces($saleId));
		}
		if (empty($province))
			return array();
		$data = Customer::model()->findAll(array(
				'select'=>'District',
				'distinct'=>true,
				'condition'=>'SaleId=:SaleId AND Province=:Province',
				'params'=>array(':SaleId'=>$saleId,':Province'=>$province)
				));
		return array_merge(array(''=>'(ทั้งหมด)'), CHtml::listData($data,'District','District'));
	}

	public static function getSaleSubDistricts($saleId, $province, $district) {
		if (empty($saleId)) {
		 	$saleId = array_shift(array_keys(Employee::model()->getAssignedOptions()));
		}
		if (empty($saleId))
			return array();
		if (empty($province)) {
			$province = array_shift(Customer::model()->getSaleProvinces($saleId));
		}
		if (empty($province))
			return array();
		$data = Customer::model()->findAll(array(
				'select'=>'SubDistrict',
				'distinct'=>true,
				'condition'=>'SaleId=:SaleId AND Province=:Province AND District=:District',
				'params'=>array(':SaleId'=>$saleId,':Province'=>$province,':District'=>$district)
				));
		return array_merge(array(''=>'(ทั้งหมด)'), CHtml::listData($data,'SubDistrict','SubDistrict'));
	}

	public static function getNoPromotionProvinces($saleId) {
		if (empty($saleId)) {
			$saleId = array_shift(array_keys(SaleUnit::model()->getNoPromotionOptions()));
		}
		if (empty($saleId))
		 	return array(''=>'-');
		$data = Customer::model()->findAll(array(
				'select'=>'Province',
				'distinct'=>true,
				'condition'=>"SaleId=:SaleId AND PromotionSku IS NULL AND PromotionGroup IS NULL AND PromotionBill IS NULL AND PromotionAccu IS NULL",
				'params'=>array(':SaleId'=>$saleId)
				));
		if (count($data) == 0)
			return array(''=>'-');
		return array('%'=>'(ทั้งหมด)')+CHtml::listData($data,'Province','Province');
	}

	public static function getNoPromotionDistricts($saleId, $province) {
		if (empty($saleId)) {
			$saleId = array_shift(array_keys(SaleUnit::model()->getNoPromotionOptions()));
		}
		if (empty($saleId))
			return array('%'=>'-');
		if (empty($province)) {
			$lists = Customer::model()->getNoPromotionProvinces($saleId);
			array_shift($lists);
			$province = array_shift($lists);;
		}
		if (empty($province))
			return array('%'=>'-');
		$data = Customer::model()->findAll(array(
				'select'=>'District',
				'distinct'=>true,
				'condition'=>'SaleId=:SaleId AND Province=:Province AND PromotionSku IS NULL AND PromotionGroup IS NULL AND PromotionBill IS NULL AND PromotionAccu IS NULL',
				'params'=>array(':SaleId'=>$saleId,':Province'=>$province)
				));
		if (count($data) == 0)
			return array('%'=>'-');
		return array('%'=>'(ทั้งหมด)')+CHtml::listData($data,'District','District');
	}

	public static function getNoPromotionSubDistricts($saleId, $province, $district) {
		if (empty($saleId)) {
			$saleId = array_shift(array_keys(SaleUnit::model()->getNoPromotionOptions()));
		}
		if (empty($saleId))
			return array('%'=>'-');
		if (empty($province)) {
			$lists = Customer::model()->getNoPromotionProvinces($saleId);
			array_shift($lists);
			$province = array_shift($lists);;
		}
		if (empty($province))
			return array('%'=>'-');
		if (empty($district)) {
			$lists = Customer::model()->getNoPromotionDistricts($saleId,$province);
			array_shift($lists);
			$district = array_shift($lists);;
		}
		if (empty($district))
			return array('%'=>'-');
		$data = Customer::model()->findAll(array(
				'select'=>'SubDistrict',
				'distinct'=>true,
				'condition'=>'SaleId=:SaleId AND Province=:Province AND District=:District AND PromotionSku IS NULL AND PromotionGroup IS NULL AND PromotionBill IS NULL AND PromotionAccu IS NULL',
				'params'=>array(':SaleId'=>$saleId,':Province'=>$province,':District'=>$district)
				));
		if (count($data) == 0)
			return array('%'=>'-');
		return array('%'=>'(ทั้งหมด)')+CHtml::listData($data,'SubDistrict','SubDistrict');
	}
}