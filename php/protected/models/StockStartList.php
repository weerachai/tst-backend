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
			'GrpLevel2Id' => Yii::t('app', 'กลุ่มกลาง'),
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
}