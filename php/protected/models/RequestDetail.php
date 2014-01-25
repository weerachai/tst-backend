<?php

Yii::import('application.models._base.BaseRequestDetail');

class RequestDetail extends BaseRequestDetail
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'product' => array(self::BELONGS_TO, 'Product', 'ProductId'),
			'stockRequest' => array(self::BELONGS_TO, 'StockRequest', 'RequestNo'),
		);
	}

	public $GrpLevel1Id;
	public $GrpLevel2Id;
	public $GrpLevel3Id;
	public $ProductIdName;

	public function attributeLabels() {
		return array(
			'RequestNo' => Yii::t('app', 'เลชที่ใบเบิก'),
			'ProductId' => Yii::t('app', 'สินค้า'),
			'QtyLevel1' => Yii::t('app', 'จำนวน'),
			'QtyLevel2' => Yii::t('app', 'จำนวน'),
			'QtyLevel3' => Yii::t('app', 'จำนวน'),
			'QtyLevel4' => Yii::t('app', 'จำนวน'),
			'UpdateAt' => Yii::t('app', 'Update At'),
			'GrpLevel1Id' => Yii::t('app', 'กลุ่มใหญ่'),
			'GrpLevel2Id' => Yii::t('app', 'กลุ่มกลาง'),
			'GrpLevel3Id' => Yii::t('app', 'กลุ่มย่อย'),
			'ProductIdName' => Yii::t('app', 'รหัส/ชื่อสิ้นค้า'),
		);
	}

	public function rules() {
		return array(
			array('ProductId', 'required'),
			array('QtyLevel1, QtyLevel2, QtyLevel3, QtyLevel4', 'numerical', 'integerOnly'=>true, 'min'=>0),
			array('QtyLevel1, QtyLevel2, QtyLevel3, QtyLevel4', 'checkMinimum'),
			array('RequestNo, ProductId', 'length', 'max'=>255),
			array('PriceLevel1, PriceLevel2, PriceLevel3, PriceLevel4', 'length', 'max'=>10),
			array('UpdateAt', 'safe'),
			array('RequestNo, ProductId, QtyLevel1, QtyLevel2, QtyLevel3, QtyLevel4, PriceLevel1, PriceLevel2, PriceLevel3, PriceLevel4, UpdateAt', 'default', 'setOnEmpty' => true, 'value' => null),
			array('RequestNo, ProductId, QtyLevel1, QtyLevel2, QtyLevel3, QtyLevel4, PriceLevel1, PriceLevel2, PriceLevel3, PriceLevel4, UpdateAt', 'safe', 'on'=>'search'),
		);
	}

	public function checkMinimum($attribute)
	{
		$product = Product::model()->findByPk($this->ProductId);
		if ($attribute == 'QtyLevel1' && empty($product->PackLevel1))
			return;
		if ($attribute == 'QtyLevel2' && empty($product->PackLevel2))
			return;
		if ($attribute == 'QtyLevel3' && empty($product->PackLevel3))
			return;
		if ($attribute == 'QtyLevel4' && empty($product->PackLevel4))
			return;
		if ($this->$attribute == 0 &&
			($this->QtyLevel1 + $this->QtyLevel2 + $this->QtyLevel3 + $this->QtyLevel4) <= 0)
	    	$this->addError($attribute, 'จำนวนสินค้าต้องไม่เป็น 0 ทุกหน่วย');
	}

	public static function getGrpLevel1($requestNo) {
		$sql = <<<SQL
			SELECT GrpLevel1Id, GrpLevel1Name
			FROM Product JOIN GrpLevel1 USING(GrpLevel1Id)
			WHERE
			ProductId NOT IN (
				SELECT ProductId 
				FROM RequestDetail
				WHERE RequestNo='$requestNo'
			)
SQL;

		$data = Yii::app()->db->createCommand($sql)->queryAll();
		return array(''=>'(ทั้งหมด)') + CHtml::listData($data,'GrpLevel1Id','GrpLevel1Name');
	}

	public static function getGrpLevel2($requestNo,$grpLevel1Id) {
		$sql = <<<SQL
			SELECT GrpLevel2Id, GrpLevel2Name
			FROM Product JOIN GrpLevel2 USING(GrpLevel2Id)
			WHERE Product.GrpLevel1Id = '$grpLevel1Id' AND
			ProductId NOT IN (
				SELECT ProductId 
				FROM RequestDetail
				WHERE RequestNo='$requestNo'
			)
SQL;

		$data = Yii::app()->db->createCommand($sql)->queryAll();
		return array(''=>'(ทั้งหมด)') + CHtml::listData($data,'GrpLevel2Id','GrpLevel2Name');
	}

	public static function getGrpLevel3($requestNo,$grpLevel1Id,$grpLevel2Id) {		
		$sql = <<<SQL
			SELECT GrpLevel3Id, GrpLevel3Name
			FROM Product JOIN GrpLevel3 USING(GrpLevel3Id)
			WHERE Product.GrpLevel1Id = '$grpLevel1Id' AND
			Product.GrpLevel2Id = '$grpLevel2Id' AND
			ProductId NOT IN (
				SELECT ProductId 
				FROM RequestDetail
				WHERE RequestNo='$requestNo'
			)
SQL;

		$data = Yii::app()->db->createCommand($sql)->queryAll();
		return array(''=>'(ทั้งหมด)') + CHtml::listData($data,'GrpLevel3Id','GrpLevel3Name');
	}

	public static function getProduct($requestNo,$grpLevel1Id,$grpLevel2Id,$grpLevel3Id,$productIdName) {
		if (empty($grpLevel1Id))
			$grpLevel1Id = '%';
		if (empty($grpLevel2Id))
			$grpLevel2Id = '%';
		if (empty($grpLevel3Id))
			$grpLevel3Id = '%';
		
		$sql = <<<SQL
			SELECT ProductId, ProductName
			FROM Product
			WHERE GrpLevel1Id LIKE '$grpLevel1Id' AND
			GrpLevel2Id LIKE '$grpLevel2Id' AND
			GrpLevel3Id LIKE '$grpLevel3Id' AND
			(ProductId LIKE '%$productIdName%' OR ProductName LIKE '%$productIdName%')
			AND ProductId NOT IN (
				SELECT ProductId 
				FROM RequestDetail
				WHERE RequestNo='$requestNo'
			)
SQL;

		$data = Yii::app()->db->createCommand($sql)->queryAll();
		return CHtml::listData($data,'ProductId','ProductName');
	}

}