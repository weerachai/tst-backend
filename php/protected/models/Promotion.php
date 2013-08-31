<?php

Yii::import('application.models._base.BasePromotion');

class Promotion extends BasePromotion
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function attributeLabels() {
		return array(
			'PromotionGroup' => Yii::t('app', 'ชุดโปรโมชั่น'),
			'PromotionId' => Yii::t('app', 'รหัสโปรโมชั่น'),
			'StartDate' => Yii::t('app', 'เริ่มวันที่'),
			'EndDate' => Yii::t('app', 'สิ้นสุดวันที่'),
			'PromotionType' => Yii::t('app', 'ประเภท'),
			'ProductOrGrpId' => Yii::t('app', 'ชื่อสินค้า/กลุ่มสินค้า'),
			'MinAmount' => Yii::t('app', 'มูลค่า'),
			'MinSku' => Yii::t('app', 'หรือจำนวน'),
			'MinQty' => Yii::t('app', 'หรือจำนวน'),
			'Pack' => Yii::t('app', 'บรรจุ'),
			'DiscBaht' => Yii::t('app', 'มูลค่า'),
			'DiscPerAmount' => Yii::t('app', 'ทุกๆ'),
			'DiscPerQty' => Yii::t('app', 'หรือทุกๆ'),
			'DiscPer1' => Yii::t('app', 'ลดเปอร์เซ็นต์ที่ 1'),
			'DiscPer2' => Yii::t('app', 'ลดเปอร์เซ็นต์ที่ 2'),
			'DiscPer3' => Yii::t('app', 'ลดเปอร์เซ็นต์ที่ 3'),
			'FreeType' => Yii::t('app', 'กลุ่มของแถม'),
			'FreeProductOrGrpId' => Yii::t('app', 'ชื่อสินค้า/กลุ่มสินค้า'),
			'FreeQty' => Yii::t('app', 'จำนวน'),
			'FreeBaht' => Yii::t('app', 'หรือมูลค่า'),
			'FreePack' => Yii::t('app', 'บรรจุ'),
			'FreePerAmount' => Yii::t('app', 'ทุกๆ'),
			'FreePerQty' => Yii::t('app', 'หรือทุกๆ'),
			'Formula' => Yii::t('app', 'สูตร'),
			'UpdateAt' => Yii::t('app', 'Update At'),
		);
	}

	public function rules() {
		return array(
			array('PromotionGroup, PromotionId, StartDate, EndDate, PromotionType, Formula', 'required'),
			array('PromotionId', 'unique'),
			array('EndDate', 'compare', 'compareAttribute'=>'StartDate' , 'operator'=>'>='),
			array('StartDate', 'compare', 'compareValue'=>date("Y-m-d") , 'operator'=>'>=', 'on'=>'insert'),
			array('MinAmount, MinSku, MinQty, DiscBaht, DiscPerAmount, DiscPerQty, DiscPer1, DiscPer2, DiscPer3, FreeQty, FreePerAmount, FreePerQty, FreeBaht', 'numerical', 'integerOnly'=>true, 'min'=>0, 'tooSmall'=>'จำนวนต้องไม่ติดลบ'),
			array('PromotionGroup, PromotionId, PromotionType, ProductOrGrpId, Pack, FreeType, FreeProductOrGrpId, FreePack, Formula', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			array('ProductOrGrpId, Pack, FreeType, FreeProductOrGrpId, FreePack', 'default', 'setOnEmpty' => true, 'value' => ''),
			array('MinAmount, MinSku, MinQty, DiscBaht, DiscPerAmount, DiscPerQty, DiscPer1, DiscPer2, DiscPer3, FreeQty, FreePerAmount, FreePerQty, FreeBaht', 'default', 'setOnEmpty' => true, 'value' => 0),
			array('PromotionGroup, PromotionId, StartDate, EndDate, PromotionType, ProductOrGrpId, MinAmount, MinSku, MinQty, Pack, DiscBaht, DiscPerAmount, DiscPerQty, DiscPer1, DiscPer2, DiscPer3, FreeType, FreeProductOrGrpId, FreeQty, FreePack, FreePerAmount, FreePerQty, FreeBaht, Formula, UpdateAt', 'safe', 'on'=>'search'),
		);
	}

	public function afterValidate()
	{
		if ($this->MinAmount == 0 && $this->MinSku == 0 && $this->MinQty == 0)
	    {
	    	$this->addError('', Yii::t('user', 'กรุณาระบุขั้นต่ำ 1 รายการ'));
	        $this->addError('MinAmount','');
		    $this->addError('MinSku','');
	        $this->addError('MinQty','');
	        return false;
	    }

	    if ($this->MinQty > 0 && empty($this->Pack))
	    {
	        $this->addError('MinQty', Yii::t('user', 'กรุณาระบุหน่วยขั้นต่ำ'));
	        $this->addError('Pack','');
	        return false;
	    }

		if ($this->DiscBaht == 0 && $this->DiscPer1 == 0 && empty($this->FreeType))
	    {
	        $this->addError('', Yii::t('user', 'กรุณาระบุส่วนลดและ/หรือของแถม'));
	        $this->addError('DiscBaht','');
	        $this->addError('DiscPer1','');
	        $this->addError('FreeType','');
	        $this->addError('FreeProductOrGrpId','');
	        return false;
	    }

		if (!empty($this->FreeType) && $this->FreeQty == 0 && $this->FreeBaht == 0)
	    {
	    	$this->addError('', Yii::t('user', 'กรุณาระบุจำนวนหรือมูลค่าของแถม'));
	        $this->addError('FreeQty','');
	        $this->addError('FreePack','');
		    $this->addError('FreeBaht','');
	        return false;
	    }

	    if ($this->FreeQty > 0 && empty($this->FreePack))
	    {
	        $this->addError('FreeQty', Yii::t('user', 'กรุณาระบุหน่วยของแถม'));
	        $this->addError('FreePack','');
	        return false;
	    }

	    return true;
	}

	public static function getPromotionTypeName($type) {
		$a = array(
			'sku' => 'รายสินค้า',
			'group' => 'คละสินค้า',
			'bill' => 'ท้ายบิล',
			'accu-all' => 'สะสมทั้งหมด',
			'accu-l1' => 'สะสมกลุ่มใหญ่',
			'accu-l2' => 'สะสมกลุ่มกลาง',
			'accu-l3' => 'สะสมกลุ่มย่อย',
			'accu-sku' => 'สะสมรายสินค้า',
		);
		return $a[$type];
	}

	public static function getProductOrGrpName($type, $id) {
		if ($type == 'sku' || $type == 'accu-sku')
			return Product::model()->findByPk($id)->ProductName;
		if ($type == 'accu-l1')
			return GrpLevel1::model()->findByPk($id)->GrpLevel1Name;
		if ($type == 'accu-l2')
			return GrpLevel2::model()->findByPk($id)->GrpLevel2Name;
		if ($type == 'accu-l3')
			return GrpLevel3::model()->findByPk($id)->GrpLevel3Name;
		return '-';
	}

	public static function getMinBuy($amount, $sku, $qty, $pack) {
		if ($amount > 0)
			return number_format($amount) . ' บาท';
		if ($sku > 0)
			return number_format($sku) . ' sku';
		if ($qty > 0)
			return number_format($qty) . ' ' . $pack;
		return '';
	}

	public static function getDiscount($model) {
		if ($model->DiscBaht > 0) {
			$str = number_format($model->DiscBaht) . ' บาท';
			if ($model->DiscPerAmount > 0)
				$str .= ' ทุกๆ ' . number_format($model->DiscPerAmount) . ' บาท';
			elseif ($model->DiscPerQty > 0)
				$str .= ' ทุกๆ ' . number_format($model->DiscPerQty) . ' ' . $model->Pack;
		} elseif ($model->DiscPer1 > 0) {
			$str = $model->DiscPer1 . '%';
			if ($model->DiscPer2 > 0)
				$str .= ', ' . $model->DiscPer2 . '%';
			if ($model->DiscPer3 > 0)
				$str .= ', ' . $model->DiscPer3 . '%';
		} else {
			$str = '-';
		}
		return $str;
	}

	public static function getFree($model) {
		if ($model->FreeType == 'S') {
			$str = Product::model()->findByPk($model->FreeProductOrGrpId)->ProductName;
			$str .= ' ' . number_format($model->FreeQty) . ' ' . $model->FreePack;
			if ($model->FreePerAmount > 0)
				$str .= ' ทุกๆ ' . number_format($model->FreePerAmount) . ' บาท';
			elseif ($model->FreePerQty > 0)
				$str .= ' ทุกๆ ' . number_format($model->FreePerQty) . ' ' . $model->Pack;
		} elseif ($model->FreeType == 'G') {
			$str = 'สินค้าในกลุ่ม ' . $model->FreeProductOrGrpId;
			if ($model->FreeQty > 0) {
				$str .= ' ' . number_format($model->FreeQty) . ' ' . $model->FreePack;
				if ($model->FreePerAmount > 0)
					$str .= ' ทุกๆ ' . number_format($model->FreePerAmount) . ' บาท';
				elseif ($model->FreePerQty > 0)
					$str .= ' ทุกๆ ' . number_format($model->FreePerQty) . ' ' . $model->Pack;
			} else
				$str .= ' มูลค่า ' . number_format($model->FreeBaht) . ' บาท';
		} else {
			$str = '-';
		}
		return $str;
	}

	public static function getFormulaName($formula) {
		$a = array(
			'F' => 'ตายตัว',
			'M' => 'ทวีคูณ',
			'C' => 'ทวีคูณตัดตอน',
		);
		return $a[$formula];
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
			'F' => 'ตายตัว',
			'M' => 'ทวีคูณ',
			'C' => 'ทวีคูณตัดตอน',
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
			if (empty($this->ProductOrGrpId))
				$this->ProductOrGrpId = array_shift(array_keys($data));
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

	public static function getPromotionOptions($type) {
		$data = Promotion::model()->findAll(array(
				'select'=>'PromotionGroup',
				'distinct'=>true,
				'condition'=>"PromotionType LIKE '$type%'",
				));
		return CHtml::listData($data,'PromotionGroup','PromotionGroup');
	}

	// public function getPacks() {
	// 	if ($this->PromotionType == 'sku' || $this->PromotionType == 'accu-sku')
	// 		return Product::model()->findByPk($this->ProductOrGrpId)->getPacksList();
	// 	return array();
	// }

	// public function getFreePacks() {
	// 	if ($this->FreeType == 'S')
	// 		return Product::model()->findByPk($this->FreeProductOrGrpId)->getPacksList();
	// 	if ($this->FreeType == 'G') {
	// 		$sql = "SELECT DISTINCT FreePack FROM FreeGrp WHERE FreeGrpid = '".$this->FreeProductOrGrpId."'";
	// 		$data = Yii::app()->db->createCommand($sql)->queryAll();
	// 		if (count($data) == 1)
	// 			return array($data[0]['FreePack']=>$data[0]['FreePack']);
	// 	}
	// 	return array();
	// }
}