<?php

/**
 * This is the model base class for the table "BillCollection".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "BillCollection".
 *
 * Columns in table "BillCollection" available as properties of the model,
 * followed by relations of table "BillCollection" available as properties of the model.
 *
 * @property string $CollectionNo
 * @property string $SaleId
 * @property string $CustomerId
 * @property string $CollectionDate
 * @property string $CollectionAmount
 * @property string $PaidAmount
 * @property string $Status
 * @property string $UpdateAt
 *
 * @property Payment[] $payments
 */
abstract class BaseBillCollection extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'BillCollection';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'BillCollection|BillCollections', $n);
	}

	public static function representingColumn() {
		return 'CollectionNo';
	}

	public function rules() {
		return array(
			array('CollectionNo, SaleId, CustomerId, Status', 'length', 'max'=>255),
			array('CollectionAmount, PaidAmount', 'length', 'max'=>20),
			array('CollectionDate, UpdateAt', 'safe'),
			array('CollectionNo, SaleId, CustomerId, CollectionDate, CollectionAmount, PaidAmount, Status, UpdateAt', 'default', 'setOnEmpty' => true, 'value' => null),
			array('CollectionNo, SaleId, CustomerId, CollectionDate, CollectionAmount, PaidAmount, Status, UpdateAt', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'payments' => array(self::HAS_MANY, 'Payment', 'CollectionNo'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'CollectionNo' => Yii::t('app', 'Collection No'),
			'SaleId' => Yii::t('app', 'Sale'),
			'CustomerId' => Yii::t('app', 'Customer'),
			'CollectionDate' => Yii::t('app', 'Collection Date'),
			'CollectionAmount' => Yii::t('app', 'Collection Amount'),
			'PaidAmount' => Yii::t('app', 'Paid Amount'),
			'Status' => Yii::t('app', 'Status'),
			'UpdateAt' => Yii::t('app', 'Update At'),
			'payments' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('CollectionNo', $this->CollectionNo, true);
		$criteria->compare('SaleId', $this->SaleId, true);
		$criteria->compare('CustomerId', $this->CustomerId, true);
		$criteria->compare('CollectionDate', $this->CollectionDate, true);
		$criteria->compare('CollectionAmount', $this->CollectionAmount, true);
		$criteria->compare('PaidAmount', $this->PaidAmount, true);
		$criteria->compare('Status', $this->Status, true);
		$criteria->compare('UpdateAt', $this->UpdateAt, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}