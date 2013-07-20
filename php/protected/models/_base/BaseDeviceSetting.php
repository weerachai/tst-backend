<?php

/**
 * This is the model base class for the table "DeviceSetting".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "DeviceSetting".
 *
 * Columns in table "DeviceSetting" available as properties of the model,
 * and there are no model relations.
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
 * @property string $UpdateAt
 *
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
			array('SaleId, SaleType, Vat, OverStock, DayToClear', 'required'),
			array('DayToClear', 'numerical', 'integerOnly'=>true),
			array('SaleId, SaleType, PromotionSku, PromotionGroup, PromotionBill, PromotionAccu, Vat', 'length', 'max'=>255),
			array('OverStock', 'length', 'max'=>1),
			array('UpdateAt', 'safe'),
			array('PromotionSku, PromotionGroup, PromotionBill, PromotionAccu, UpdateAt', 'default', 'setOnEmpty' => true, 'value' => null),
			array('SaleId, SaleType, PromotionSku, PromotionGroup, PromotionBill, PromotionAccu, Vat, OverStock, DayToClear, UpdateAt', 'safe', 'on'=>'search'),
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
			'SaleId' => Yii::t('app', 'Sale'),
			'SaleType' => Yii::t('app', 'Sale Type'),
			'PromotionSku' => Yii::t('app', 'Promotion Sku'),
			'PromotionGroup' => Yii::t('app', 'Promotion Group'),
			'PromotionBill' => Yii::t('app', 'Promotion Bill'),
			'PromotionAccu' => Yii::t('app', 'Promotion Accu'),
			'Vat' => Yii::t('app', 'Vat'),
			'OverStock' => Yii::t('app', 'Over Stock'),
			'DayToClear' => Yii::t('app', 'Day To Clear'),
			'UpdateAt' => Yii::t('app', 'Update At'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('SaleId', $this->SaleId, true);
		$criteria->compare('SaleType', $this->SaleType, true);
		$criteria->compare('PromotionSku', $this->PromotionSku, true);
		$criteria->compare('PromotionGroup', $this->PromotionGroup, true);
		$criteria->compare('PromotionBill', $this->PromotionBill, true);
		$criteria->compare('PromotionAccu', $this->PromotionAccu, true);
		$criteria->compare('Vat', $this->Vat, true);
		$criteria->compare('OverStock', $this->OverStock, true);
		$criteria->compare('DayToClear', $this->DayToClear);
		$criteria->compare('UpdateAt', $this->UpdateAt, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}