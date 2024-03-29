<?php

/**
 * This is the model base class for the table "Product".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Product".
 *
 * Columns in table "Product" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $GrpLevel1Id
 * @property string $GrpLevel2Id
 * @property string $GrpLevel3Id
 * @property string $ProductId
 * @property string $ProductName
 * @property string $PackLevel1
 * @property string $PackLevel2
 * @property string $PackLevel3
 * @property string $PackLevel4
 * @property string $PriceLevel1
 * @property string $PriceLevel2
 * @property string $PriceLevel3
 * @property string $PriceLevel4
 * @property integer $VolumeLevel1
 * @property integer $VolumeLevel2
 * @property integer $VolumeLevel3
 * @property integer $VolumeLevel4
 * @property string $FreeFlag
 * @property string $VatFlag
 * @property string $ShipFlag
 * @property string $MinShip
 * @property string $ShipFee
 * @property string $UpdateAt
 *
 */
abstract class BaseProduct extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'Product';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Product|Products', $n);
	}

	public static function representingColumn() {
		return 'GrpLevel1Id';
	}

	public function rules() {
		return array(
			array('ProductId, ProductName', 'required'),
			array('VolumeLevel1, VolumeLevel2, VolumeLevel3, VolumeLevel4', 'numerical', 'integerOnly'=>true),
			array('GrpLevel1Id, GrpLevel2Id, GrpLevel3Id, ProductId, ProductName, PackLevel1, PackLevel2, PackLevel3, PackLevel4', 'length', 'max'=>255),
			array('PriceLevel1, PriceLevel2, PriceLevel3, PriceLevel4, MinShip, ShipFee', 'length', 'max'=>10),
			array('FreeFlag, VatFlag, ShipFlag', 'length', 'max'=>1),
			array('UpdateAt', 'safe'),
			array('GrpLevel1Id, GrpLevel2Id, GrpLevel3Id, PackLevel1, PackLevel2, PackLevel3, PackLevel4, PriceLevel1, PriceLevel2, PriceLevel3, PriceLevel4, VolumeLevel1, VolumeLevel2, VolumeLevel3, VolumeLevel4, FreeFlag, VatFlag, ShipFlag, MinShip, ShipFee, UpdateAt', 'default', 'setOnEmpty' => true, 'value' => null),
			array('GrpLevel1Id, GrpLevel2Id, GrpLevel3Id, ProductId, ProductName, PackLevel1, PackLevel2, PackLevel3, PackLevel4, PriceLevel1, PriceLevel2, PriceLevel3, PriceLevel4, VolumeLevel1, VolumeLevel2, VolumeLevel3, VolumeLevel4, FreeFlag, VatFlag, ShipFlag, MinShip, ShipFee, UpdateAt', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'GrpLevel1Id' => Yii::t('app', 'Grp Level1'),
			'GrpLevel2Id' => Yii::t('app', 'Grp Level2'),
			'GrpLevel3Id' => Yii::t('app', 'Grp Level3'),
			'ProductId' => Yii::t('app', 'Product'),
			'ProductName' => Yii::t('app', 'Product Name'),
			'PackLevel1' => Yii::t('app', 'Pack Level1'),
			'PackLevel2' => Yii::t('app', 'Pack Level2'),
			'PackLevel3' => Yii::t('app', 'Pack Level3'),
			'PackLevel4' => Yii::t('app', 'Pack Level4'),
			'PriceLevel1' => Yii::t('app', 'Price Level1'),
			'PriceLevel2' => Yii::t('app', 'Price Level2'),
			'PriceLevel3' => Yii::t('app', 'Price Level3'),
			'PriceLevel4' => Yii::t('app', 'Price Level4'),
			'VolumeLevel1' => Yii::t('app', 'Volume Level1'),
			'VolumeLevel2' => Yii::t('app', 'Volume Level2'),
			'VolumeLevel3' => Yii::t('app', 'Volume Level3'),
			'VolumeLevel4' => Yii::t('app', 'Volume Level4'),
			'FreeFlag' => Yii::t('app', 'Free Flag'),
			'VatFlag' => Yii::t('app', 'Vat Flag'),
			'ShipFlag' => Yii::t('app', 'Ship Flag'),
			'MinShip' => Yii::t('app', 'Min Ship'),
			'ShipFee' => Yii::t('app', 'Ship Fee'),
			'UpdateAt' => Yii::t('app', 'Update At'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('GrpLevel1Id', $this->GrpLevel1Id, true);
		$criteria->compare('GrpLevel2Id', $this->GrpLevel2Id, true);
		$criteria->compare('GrpLevel3Id', $this->GrpLevel3Id, true);
		$criteria->compare('ProductId', $this->ProductId, true);
		$criteria->compare('ProductName', $this->ProductName, true);
		$criteria->compare('PackLevel1', $this->PackLevel1, true);
		$criteria->compare('PackLevel2', $this->PackLevel2, true);
		$criteria->compare('PackLevel3', $this->PackLevel3, true);
		$criteria->compare('PackLevel4', $this->PackLevel4, true);
		$criteria->compare('PriceLevel1', $this->PriceLevel1, true);
		$criteria->compare('PriceLevel2', $this->PriceLevel2, true);
		$criteria->compare('PriceLevel3', $this->PriceLevel3, true);
		$criteria->compare('PriceLevel4', $this->PriceLevel4, true);
		$criteria->compare('VolumeLevel1', $this->VolumeLevel1);
		$criteria->compare('VolumeLevel2', $this->VolumeLevel2);
		$criteria->compare('VolumeLevel3', $this->VolumeLevel3);
		$criteria->compare('VolumeLevel4', $this->VolumeLevel4);
		$criteria->compare('FreeFlag', $this->FreeFlag, true);
		$criteria->compare('VatFlag', $this->VatFlag, true);
		$criteria->compare('ShipFlag', $this->ShipFlag, true);
		$criteria->compare('MinShip', $this->MinShip, true);
		$criteria->compare('ShipFee', $this->ShipFee, true);
		$criteria->compare('UpdateAt', $this->UpdateAt, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}