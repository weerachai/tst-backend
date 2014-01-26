<?php

/**
 * This is the model base class for the table "DeviceSetting".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "DeviceSetting".
 *
 * Columns in table "DeviceSetting" available as properties of the model,
 * followed by relations of table "DeviceSetting" available as properties of the model.
 *
 * @property string $SaleId
 * @property string $SaleType
 * @property string $PromotionSku
 * @property string $PromotionGroup
 * @property string $PromotionBill
 * @property string $PromotionAccu
 * @property string $Vat
 * @property string $OverStock
 * @property integer $DayToClear
 * @property integer $ExchangeDiff
 * @property string $ExchangePaymentMethod
 * @property integer $Capacity
 * @property string $UpdateAt
 *
 * @property SaleUnit $sale
 */
abstract class BaseDeviceSetting extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'DeviceSetting';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'DeviceSetting|DeviceSettings', $n);
	}

	public static function representingColumn() {
		return 'SaleType';
	}

	public function rules() {
		return array(
			array('SaleId, SaleType, Vat, OverStock, DayToClear, ExchangeDiff, ExchangePaymentMethod', 'required'),
			array('DayToClear, ExchangeDiff, Capacity', 'numerical', 'integerOnly'=>true),
			array('SaleId, SaleType, PromotionSku, PromotionGroup, PromotionBill, PromotionAccu, Vat, ExchangePaymentMethod', 'length', 'max'=>255),
			array('OverStock', 'length', 'max'=>1),
			array('UpdateAt', 'safe'),
			array('PromotionSku, PromotionGroup, PromotionBill, PromotionAccu, Capacity, UpdateAt', 'default', 'setOnEmpty' => true, 'value' => null),
			array('SaleId, SaleType, PromotionSku, PromotionGroup, PromotionBill, PromotionAccu, Vat, OverStock, DayToClear, ExchangeDiff, ExchangePaymentMethod, Capacity, UpdateAt', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'sale' => array(self::BELONGS_TO, 'SaleUnit', 'SaleId'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'SaleId' => null,
			'SaleType' => Yii::t('app', 'Sale Type'),
			'PromotionSku' => Yii::t('app', 'Promotion Sku'),
			'PromotionGroup' => Yii::t('app', 'Promotion Group'),
			'PromotionBill' => Yii::t('app', 'Promotion Bill'),
			'PromotionAccu' => Yii::t('app', 'Promotion Accu'),
			'Vat' => Yii::t('app', 'Vat'),
			'OverStock' => Yii::t('app', 'Over Stock'),
			'DayToClear' => Yii::t('app', 'Day To Clear'),
			'ExchangeDiff' => Yii::t('app', 'Exchange Diff'),
			'ExchangePaymentMethod' => Yii::t('app', 'Exchange Payment Method'),
			'Capacity' => Yii::t('app', 'Capacity'),
			'UpdateAt' => Yii::t('app', 'Update At'),
			'sale' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('SaleId', $this->SaleId);
		$criteria->compare('SaleType', $this->SaleType, true);
		$criteria->compare('PromotionSku', $this->PromotionSku, true);
		$criteria->compare('PromotionGroup', $this->PromotionGroup, true);
		$criteria->compare('PromotionBill', $this->PromotionBill, true);
		$criteria->compare('PromotionAccu', $this->PromotionAccu, true);
		$criteria->compare('Vat', $this->Vat, true);
		$criteria->compare('OverStock', $this->OverStock, true);
		$criteria->compare('DayToClear', $this->DayToClear);
		$criteria->compare('ExchangeDiff', $this->ExchangeDiff);
		$criteria->compare('ExchangePaymentMethod', $this->ExchangePaymentMethod, true);
		$criteria->compare('Capacity', $this->Capacity);
		$criteria->compare('UpdateAt', $this->UpdateAt, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}