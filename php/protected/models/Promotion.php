<?php

Yii::import('application.models._base.BasePromotion');

class Promotion extends BasePromotion
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function getPromotionTypes() {
		if (empty($this->PromotionType))
			$this->PromotionType = 'sku';
		return array(
			'sku' => 'รายสินค้า',
			'group' => 'คละสินค้า',
			'bill' => 'ท้ายบิล',
			'accu-all' => 'สะสมทั้งหมด',
			'accu-l1' => 'สะสมกลุ่มใหญ่',
			'accu-l2' => 'สะสมกลุ่มกลาง',
			'accu-l3' => 'สะสมกลุ่มย่อย',
			'accu-sku' => 'สะสมรายสินค้า',
		);
	}

	public function getFreeTypes() {
		return array(
			'S' => 'รายสินค้า',
			'G' => 'กลุ่มสินค้า',
		);
	}

	public function getFormulas() {
		return array(
			'F' => 'Level Fixed',
			'M' => 'Level คูณเพิ่ม',
			'C' => 'Level คูณเพิ่ม + ตัดทอน',
		);
	}

	public static function getProductGroups() {
		$data = ProductGrp::model()->findAll(array(
				'select'=>'ProductGrpId',
				'distinct'=>true
				));
		return CHtml::listData($data,'ProductGrpId','ProductGrpId');
	}

	public function getProductsOrGroups() {
		$type = $this->PromotionType;
		if ($type == 'sku' || $type == 'accu-sku') {
			$data = Product::model()->getOptions();
		} else if ($type == 'group') {
			$data = Promotion::model()->getProductGroups();
		} else if ($type == 'accu-l1') {
			$data = Product::model()->getGroupLevel1();
		} else if ($type == 'accu-l2') {
			$data = Product::model()->getGroupLevel2();
		} else if ($type == 'accu-l3') {
			$data = Product::model()->getGroupLevel3();
		} else {
			$data = array(''=>'-');
		}
		return $data;
	}

	public static function getFreeProductGroups() {
		$data = FreeGrp::model()->findAll(array(
				'select'=>'FreeGrpId',
				'distinct'=>true
				));
		return CHtml::listData($data,'FreeGrpId','FreeGrpId');
	}

	public function getFreeProductsOrGroups() {
		$type = $this->FreeType;
		if ($type == 'S') {
			$data = Product::model()->getOptions();
		} else if ($type == 'G') {
			$data = Promotion::model()->getFreeProductGroups();
		} else {
			$data = array(''=>'-');
		}
		return $data;
	}
}