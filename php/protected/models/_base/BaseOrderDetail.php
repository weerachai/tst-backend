<?php

/**
 * This is the model base class for the table "OrderDetail".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "OrderDetail".
 *
 * Columns in table "OrderDetail" available as properties of the model,
 * followed by relations of table "OrderDetail" available as properties of the model.
 *
 * @property string $OrderNo
 * @property string $ProductId
 * @property integer $BuyLevel1
 * @property integer $BuyLevel2
 * @property integer $BuyLevel3
 * @property integer $BuyLevel4
 * @property string $PriceLevel1
 * @property string $PriceLevel2
 * @property string $PriceLevel3
 * @property string $PriceLevel4
 * @property string $PromotionAccuId
 * @property string $PromotionAccuType
 * @property string $OrderNoUsed
 * @property string $UpdateAt
 *
 * @property ProductOrder $orderNo
 */
abstract class BaseOrderDetail extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'OrderDetail';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'OrderDetail|OrderDetails', $n);
	}

	public static function representingColumn() {
		return 'ProductId';
	}

	public function rules() {
		return array(
			array('BuyLevel1, BuyLevel2, BuyLevel3, BuyLevel4', 'numerical', 'integerOnly'=>true),
			array('OrderNo, ProductId, PromotionAccuId, PromotionAccuType, OrderNoUsed', 'length', 'max'=>255),
			array('PriceLevel1, PriceLevel2, PriceLevel3, PriceLevel4', 'length', 'max'=>10),
			array('UpdateAt', 'safe'),
			array('OrderNo, ProductId, BuyLevel1, BuyLevel2, BuyLevel3, BuyLevel4, PriceLevel1, PriceLevel2, PriceLevel3, PriceLevel4, PromotionAccuId, PromotionAccuType, OrderNoUsed, UpdateAt', 'default', 'setOnEmpty' => true, 'value' => null),
			array('OrderNo, ProductId, BuyLevel1, BuyLevel2, BuyLevel3, BuyLevel4, PriceLevel1, PriceLevel2, PriceLevel3, PriceLevel4, PromotionAccuId, PromotionAccuType, OrderNoUsed, UpdateAt', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'orderNo' => array(self::BELONGS_TO, 'ProductOrder', 'OrderNo'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'OrderNo' => null,
			'ProductId' => Yii::t('app', 'Product'),
			'BuyLevel1' => Yii::t('app', 'Buy Level1'),
			'BuyLevel2' => Yii::t('app', 'Buy Level2'),
			'BuyLevel3' => Yii::t('app', 'Buy Level3'),
			'BuyLevel4' => Yii::t('app', 'Buy Level4'),
			'PriceLevel1' => Yii::t('app', 'Price Level1'),
			'PriceLevel2' => Yii::t('app', 'Price Level2'),
			'PriceLevel3' => Yii::t('app', 'Price Level3'),
			'PriceLevel4' => Yii::t('app', 'Price Level4'),
			'PromotionAccuId' => Yii::t('app', 'Promotion Accu'),
			'PromotionAccuType' => Yii::t('app', 'Promotion Accu Type'),
			'OrderNoUsed' => Yii::t('app', 'Order No Used'),
			'UpdateAt' => Yii::t('app', 'Update At'),
			'orderNo' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('OrderNo', $this->OrderNo);
		$criteria->compare('ProductId', $this->ProductId, true);
		$criteria->compare('BuyLevel1', $this->BuyLevel1);
		$criteria->compare('BuyLevel2', $this->BuyLevel2);
		$criteria->compare('BuyLevel3', $this->BuyLevel3);
		$criteria->compare('BuyLevel4', $this->BuyLevel4);
		$criteria->compare('PriceLevel1', $this->PriceLevel1, true);
		$criteria->compare('PriceLevel2', $this->PriceLevel2, true);
		$criteria->compare('PriceLevel3', $this->PriceLevel3, true);
		$criteria->compare('PriceLevel4', $this->PriceLevel4, true);
		$criteria->compare('PromotionAccuId', $this->PromotionAccuId, true);
		$criteria->compare('PromotionAccuType', $this->PromotionAccuType, true);
		$criteria->compare('OrderNoUsed', $this->OrderNoUsed, true);
		$criteria->compare('UpdateAt', $this->UpdateAt, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}