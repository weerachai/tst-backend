<?php

Yii::import('application.models._base.BaseStockCheckList');

class StockCheckList extends BaseStockCheckList
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public static function getCheckGrpLevel1($saleId) {
		if (empty($saleId))
			$saleId = array_shift(array_keys(SaleUnit::model()->getOptions()));
		if (empty($saleId))
			return array(''=>'(ทั้งหมด)');
		$sql = <<<SQL
			SELECT GrpLevel1Id, GrpLevel1Name
			FROM Product JOIN GrpLevel1 USING(GrpLevel1Id)
			WHERE
			ProductId NOT IN (
				SELECT P.ProductId 
				FROM Product P JOIN StockCheckList S 
				USING(GrpLevel1Id, GrpLevel2Id, GrpLevel3Id, ProductId)
				WHERE SaleId='$saleId'
				UNION
				SELECT P.ProductId 
				FROM Product P JOIN StockCheckList S 
				USING(GrpLevel1Id, GrpLevel2Id, GrpLevel3Id) 
				WHERE SaleId='$saleId' AND S.ProductId = ''
				UNION
				SELECT P.ProductId 
				FROM Product P JOIN StockCheckList S 
				USING(GrpLevel1Id, GrpLevel2Id) 
				WHERE SaleId='$saleId' AND S.GrpLevel3Id = '' 
				AND S.ProductId = ''
				UNION
				SELECT P.ProductId 
				FROM Product P JOIN StockCheckList S 
				USING(GrpLevel1Id) 
				WHERE SaleId='$saleId' AND S.GrpLevel2Id = '' 
				AND S.GrpLevel3Id = '' AND S.ProductId = ''
			)
SQL;

		$data = Yii::app()->db->createCommand($sql)->queryAll();
		return array(''=>'(ทั้งหมด)') + CHtml::listData($data,'GrpLevel1Id','GrpLevel1Name');
	}

	public static function getCheckGrpLevel2($saleId,$grpLevel1Id) {
		if (empty($saleId))
			$saleId = array_shift(array_keys(SaleUnit::model()->getOptions()));
		if (empty($saleId))
			return array();
		if (empty($grpLevel1Id))
			$grpLevel1Id = array_shift(array_keys(StockCheckList::model()->getCheckGrpLevel1($saleId)));
		if (empty($grpLevel1Id))
			return array(''=>'(ทั้งหมด)');

		$sql = <<<SQL
			SELECT GrpLevel2Id, GrpLevel2Name
			FROM Product JOIN GrpLevel2 USING(GrpLevel2Id)
			WHERE Product.GrpLevel1Id = '$grpLevel1Id' AND
			ProductId NOT IN (
				SELECT P.ProductId 
				FROM Product P JOIN StockCheckList S 
				USING(GrpLevel1Id, GrpLevel2Id, GrpLevel3Id, ProductId)
				WHERE SaleId='$saleId'
				UNION
				SELECT P.ProductId 
				FROM Product P JOIN StockCheckList S 
				USING(GrpLevel1Id, GrpLevel2Id, GrpLevel3Id) 
				WHERE SaleId='$saleId' AND S.ProductId = ''
				UNION
				SELECT P.ProductId 
				FROM Product P JOIN StockCheckList S 
				USING(GrpLevel1Id, GrpLevel2Id) 
				WHERE SaleId='$saleId' AND S.GrpLevel3Id = '' 
				AND S.ProductId = ''
				UNION
				SELECT P.ProductId 
				FROM Product P JOIN StockCheckList S 
				USING(GrpLevel1Id) 
				WHERE SaleId='$saleId' AND S.GrpLevel2Id = '' 
				AND S.GrpLevel3Id = '' AND S.ProductId = ''
			)
SQL;

		$data = Yii::app()->db->createCommand($sql)->queryAll();
		return array(''=>'(ทั้งหมด)') + CHtml::listData($data,'GrpLevel2Id','GrpLevel2Name');
	}

	public static function getCheckGrpLevel3($saleId,$grpLevel1Id,$grpLevel2Id) {
		if (empty($saleId))
			$saleId = array_shift(array_keys(SaleUnit::model()->getOptions()));
		if (empty($saleId))
			return array();
		if (empty($grpLevel1Id))
			$grpLevel1Id = array_shift(array_keys(StockCheckList::model()->getCheckGrpLevel1($saleId)));
		if (empty($grpLevel1Id))
			return array(''=>'(ทั้งหมด)');
		
		$sql = <<<SQL
			SELECT GrpLevel3Id, GrpLevel3Name
			FROM Product JOIN GrpLevel3 USING(GrpLevel3Id)
			WHERE Product.GrpLevel1Id = '$grpLevel1Id' AND
			Product.GrpLevel2Id = '$grpLevel2Id' AND
			ProductId NOT IN (
				SELECT P.ProductId 
				FROM Product P JOIN StockCheckList S 
				USING(GrpLevel1Id, GrpLevel2Id, GrpLevel3Id, ProductId)
				WHERE SaleId='$saleId'
				UNION
				SELECT P.ProductId 
				FROM Product P JOIN StockCheckList S 
				USING(GrpLevel1Id, GrpLevel2Id, GrpLevel3Id) 
				WHERE SaleId='$saleId' AND S.ProductId = ''
				UNION
				SELECT P.ProductId 
				FROM Product P JOIN StockCheckList S 
				USING(GrpLevel1Id, GrpLevel2Id) 
				WHERE SaleId='$saleId' AND S.GrpLevel3Id = '' 
				AND S.ProductId = ''
				UNION
				SELECT P.ProductId 
				FROM Product P JOIN StockCheckList S 
				USING(GrpLevel1Id) 
				WHERE SaleId='$saleId' AND S.GrpLevel2Id = '' 
				AND S.GrpLevel3Id = '' AND S.ProductId = ''
			)
SQL;

		$data = Yii::app()->db->createCommand($sql)->queryAll();
		return array(''=>'(ทั้งหมด)') + CHtml::listData($data,'GrpLevel3Id','GrpLevel3Name');
	}

	public static function getCheckProduct($saleId,$grpLevel1Id,$grpLevel2Id,$grpLevel3Id) {
		if (empty($saleId))
			$saleId = array_shift(array_keys(SaleUnit::model()->getOptions()));
		if (empty($saleId))
			return array();
		if (empty($grpLevel1Id))
			$grpLevel1Id = array_shift(array_keys(StockCheckList::model()->getCheckGrpLevel1($saleId)));
		if (empty($grpLevel1Id))
			return array(''=>'(ทั้งหมด)');
		
		$sql = <<<SQL
			SELECT ProductId, ProductName
			FROM Product
			WHERE Product.GrpLevel1Id = '$grpLevel1Id' AND
			Product.GrpLevel2Id = '$grpLevel2Id' AND
			Product.GrpLevel3Id = '$grpLevel3Id' AND
			ProductId NOT IN (
				SELECT P.ProductId 
				FROM Product P JOIN StockCheckList S 
				USING(GrpLevel1Id, GrpLevel2Id, GrpLevel3Id, ProductId)
				WHERE SaleId='$saleId'
				UNION
				SELECT P.ProductId 
				FROM Product P JOIN StockCheckList S 
				USING(GrpLevel1Id, GrpLevel2Id, GrpLevel3Id) 
				WHERE SaleId='$saleId' AND S.ProductId = ''
				UNION
				SELECT P.ProductId 
				FROM Product P JOIN StockCheckList S 
				USING(GrpLevel1Id, GrpLevel2Id) 
				WHERE SaleId='$saleId' AND S.GrpLevel3Id = '' 
				AND S.ProductId = ''
				UNION
				SELECT P.ProductId 
				FROM Product P JOIN StockCheckList S 
				USING(GrpLevel1Id) 
				WHERE SaleId='$saleId' AND S.GrpLevel2Id = '' 
				AND S.GrpLevel3Id = '' AND S.ProductId = ''
			)
SQL;

		$data = Yii::app()->db->createCommand($sql)->queryAll();
		return array(''=>'(ทั้งหมด)') + CHtml::listData($data,'ProductId','ProductName');
	}
}