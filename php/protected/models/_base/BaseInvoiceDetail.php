<?php

/**
 * This is the model base class for the table "InvoiceDetail".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "InvoiceDetail".
 *
 * Columns in table "InvoiceDetail" available as properties of the model,
 * followed by relations of table "InvoiceDetail" available as properties of the model.
 *
 * @property string $InvoiceNo
 * @property string $ProductId
 * @property integer $QtyLevel1
 * @property integer $QtyLevel2
 * @property integer $QtyLevel3
 * @property integer $QtyLevel4
 * @property string $Status
 * @property string $UpdateAt
 *
 * @property ProductInvoice $invoiceNo
 */
abstract class BaseInvoiceDetail extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'InvoiceDetail';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'InvoiceDetail|InvoiceDetails', $n);
	}

	public static function representingColumn() {
		return 'ProductId';
	}

	public function rules() {
		return array(
			array('QtyLevel1, QtyLevel2, QtyLevel3, QtyLevel4', 'numerical', 'integerOnly'=>true),
			array('InvoiceNo, ProductId, Status', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			array('InvoiceNo, ProductId, QtyLevel1, QtyLevel2, QtyLevel3, QtyLevel4, Status, UpdateAt', 'default', 'setOnEmpty' => true, 'value' => null),
			array('InvoiceNo, ProductId, QtyLevel1, QtyLevel2, QtyLevel3, QtyLevel4, Status, UpdateAt', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'invoiceNo' => array(self::BELONGS_TO, 'ProductInvoice', 'InvoiceNo'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'InvoiceNo' => null,
			'ProductId' => Yii::t('app', 'Product'),
			'QtyLevel1' => Yii::t('app', 'Qty Level1'),
			'QtyLevel2' => Yii::t('app', 'Qty Level2'),
			'QtyLevel3' => Yii::t('app', 'Qty Level3'),
			'QtyLevel4' => Yii::t('app', 'Qty Level4'),
			'Status' => Yii::t('app', 'Status'),
			'UpdateAt' => Yii::t('app', 'Update At'),
			'invoiceNo' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('InvoiceNo', $this->InvoiceNo);
		$criteria->compare('ProductId', $this->ProductId, true);
		$criteria->compare('QtyLevel1', $this->QtyLevel1);
		$criteria->compare('QtyLevel2', $this->QtyLevel2);
		$criteria->compare('QtyLevel3', $this->QtyLevel3);
		$criteria->compare('QtyLevel4', $this->QtyLevel4);
		$criteria->compare('Status', $this->Status, true);
		$criteria->compare('UpdateAt', $this->UpdateAt, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}