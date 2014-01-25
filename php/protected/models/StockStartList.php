<?php

Yii::import('application.models._base.BaseStockStartList');

class StockStartList extends BaseStockStartList
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public $GrpLevel1Id;
	public $GrpLevel2Id;
	public $GrpLevel3Id;
	public $Type;
	public $Pack;

	public function attributeLabels() {
		return array(
			'SaleId' => Yii::t('app', 'หน่วยขาย'),
			'ProductId' => Yii::t('app', 'สินค้า'),
			'Level' => Yii::t('app', 'Level'),
			'Qty' => Yii::t('app', 'จำนวน'),
			'UpdateAt' => Yii::t('app', 'Update At'),
			'GrpLevel1Id' => Yii::t('app', 'กลุ่มใหญ่'),
			'GrpLevel2Id' => Yii::t('app', 'กลุ่มกลาง'),
			'GrpLevel3Id' => Yii::t('app', 'กลุ่มย่อย'),
			'Type' => Yii::t('app', 'ประเภท'),
			'Pack' => Yii::t('app', 'บรรจุ'),
		);
	}

	public function rules() {
		return array(
			array('SaleId, ProductId, Level, Qty, Type, Pack', 'required'),
			array('Level, Qty', 'numerical', 'integerOnly'=>true, 'min'=>1),
			array('SaleId, ProductId', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			array('UpdateAt', 'default', 'setOnEmpty' => true, 'value' => null),
			array('SaleId, ProductId, Level, Qty, UpdateAt', 'safe', 'on'=>'search'),
		);
	}

	public static function getGrpLevel1($saleId) {
		if (empty($saleId))
			$saleId = array_shift(array_keys(SaleUnit::model()->getAssigendOptions()));
		if (empty($saleId))
			return array();
		$sql = <<<SQL
			SELECT GrpLevel1Id, GrpLevel1Name
			FROM Product JOIN GrpLevel1 USING(GrpLevel1Id)
			WHERE
			ProductId NOT IN (
				SELECT ProductId 
				FROM StockStartList
				WHERE SaleId='$saleId'
			)
SQL;

		$data = Yii::app()->db->createCommand($sql)->queryAll();
		return array(''=>'(ทั้งหมด)') + CHtml::listData($data,'GrpLevel1Id','GrpLevel1Name');
	}

	public static function getGrpLevel2($saleId,$grpLevel1Id) {
		if (empty($saleId))
			$saleId = array_shift(array_keys(SaleUnit::model()->getAssigendOptions()));
		if (empty($saleId))
			return array();
		// if (empty($grpLevel1Id))
		// 	$grpLevel1Id = array_shift(array_keys(StockStartList::model()->getGrpLevel1($saleId)));
		// if (empty($grpLevel1Id))
		// 	return array();

		$sql = <<<SQL
			SELECT GrpLevel2Id, GrpLevel2Name
			FROM Product JOIN GrpLevel2 USING(GrpLevel2Id)
			WHERE Product.GrpLevel1Id = '$grpLevel1Id' AND
			ProductId NOT IN (
				SELECT ProductId 
				FROM StockStartList
				WHERE SaleId='$saleId'
			)
SQL;

		$data = Yii::app()->db->createCommand($sql)->queryAll();
		return array(''=>'(ทั้งหมด)') + CHtml::listData($data,'GrpLevel2Id','GrpLevel2Name');
	}

	public static function getGrpLevel3($saleId,$grpLevel1Id,$grpLevel2Id) {
		if (empty($saleId))
			$saleId = array_shift(array_keys(SaleUnit::model()->getAssigendOptions()));
		if (empty($saleId))
			return array();
		// if (empty($grpLevel1Id))
		// 	$grpLevel1Id = array_shift(array_keys(StockStartList::model()->getGrpLevel1($saleId)));
		// if (empty($grpLevel1Id))
		// 	return array();
		
		$sql = <<<SQL
			SELECT GrpLevel3Id, GrpLevel3Name
			FROM Product JOIN GrpLevel3 USING(GrpLevel3Id)
			WHERE Product.GrpLevel1Id = '$grpLevel1Id' AND
			Product.GrpLevel2Id = '$grpLevel2Id' AND
			ProductId NOT IN (
				SELECT ProductId 
				FROM StockStartList
				WHERE SaleId='$saleId'
			)
SQL;

		$data = Yii::app()->db->createCommand($sql)->queryAll();
		return array(''=>'(ทั้งหมด)') + CHtml::listData($data,'GrpLevel3Id','GrpLevel3Name');
	}

	public static function getType() {
		return array('a'=>'(ทั้งหมด)',
		's'=>'ขายได้',
		'f'=>'แถมได้',
		);
	}

	public static function getProduct($saleId,$grpLevel1Id,$grpLevel2Id,$grpLevel3Id,$type) {
		if (empty($saleId))
			$saleId = array_shift(array_keys(SaleUnit::model()->getAssigendOptions()));
		if (empty($saleId))
			return array();
		if (empty($grpLevel1Id))
			$grpLevel1Id = '%';
//			$grpLevel1Id = array_shift(array_keys(StockStartList::model()->getGrpLevel1($saleId)));
//		if (empty($grpLevel1Id))
//			return array();
		if (empty($grpLevel2Id))
			$grpLevel2Id = '%';
		if (empty($grpLevel3Id))
			$grpLevel3Id = '%';
		
		if ($type == 's')
			$type = 'N';
		elseif ($type == 'f')
			$type = 'Y';
		else
			$type = '%';
		$sql = <<<SQL
			SELECT ProductId, ProductName
			FROM Product
			WHERE Product.GrpLevel1Id LIKE '$grpLevel1Id' AND
			Product.GrpLevel2Id LIKE '$grpLevel2Id' AND
			Product.GrpLevel3Id LIKE '$grpLevel3Id' AND
			FreeFlag LIKE '$type' AND
			ProductId NOT IN (
				SELECT ProductId 
				FROM StockStartList
				WHERE SaleId='$saleId'
			)
SQL;

		$data = Yii::app()->db->createCommand($sql)->queryAll();
		return CHtml::listData($data,'ProductId','ProductName');
	}

	public static function getPack($productId) {	
		if (empty($productId))
			$productId = array_shift(array_keys(StockStartList::model()->getProduct('','','','','a')));	
		if (empty($productId))
			return array();
		$sql = <<<SQL
				SELECT 1 AS Level, PackLevel1 AS Pack
				FROM Product
				WHERE ProductId = '$productId' 
				AND PackLevel1 != '' AND PackLevel1 IS NOT NULL
			UNION
				SELECT 2 AS Level, PackLevel2 AS Pack
				FROM Product
				WHERE ProductId = '$productId'
				AND PackLevel2 != '' AND PackLevel2 IS NOT NULL
			UNION
				SELECT 3 AS Level, PackLevel3 AS Pack
				FROM Product
				WHERE ProductId = '$productId'
				AND PackLevel3 != '' AND PackLevel3 IS NOT NULL
			UNION
				SELECT 4 AS Level, PackLevel4 AS Pack
				FROM Product
				WHERE ProductId = '$productId'
				AND PackLevel4 != '' AND PackLevel4 IS NOT NULL
			ORDER BY Level
SQL;

		$data = Yii::app()->db->createCommand($sql)->queryAll();
		return CHtml::listData($data,'Level','Pack');
	}
}