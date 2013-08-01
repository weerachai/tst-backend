<?php

/**
 * This is the model base class for the table "InvoicePayment".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "InvoicePayment".
 *
 * Columns in table "InvoicePayment" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $PaymentId
 * @property string $InvoiceNo
 * @property string $Amount
 * @property string $UpdateAt
 *
 */
abstract class BaseInvoicePayment extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'InvoicePayment';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'InvoicePayment|InvoicePayments', $n);
	}

	public static function representingColumn() {
		return 'PaymentId';
	}

	public function rules() {
		return array(
			array('PaymentId, InvoiceNo', 'length', 'max'=>255),
			array('Amount', 'length', 'max'=>20),
			array('UpdateAt', 'safe'),
			array('PaymentId, InvoiceNo, Amount, UpdateAt', 'default', 'setOnEmpty' => true, 'value' => null),
			array('PaymentId, InvoiceNo, Amount, UpdateAt', 'safe', 'on'=>'search'),
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
			'PaymentId' => Yii::t('app', 'Payment'),
			'InvoiceNo' => Yii::t('app', 'Invoice No'),
			'Amount' => Yii::t('app', 'Amount'),
			'UpdateAt' => Yii::t('app', 'Update At'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('PaymentId', $this->PaymentId, true);
		$criteria->compare('InvoiceNo', $this->InvoiceNo, true);
		$criteria->compare('Amount', $this->Amount, true);
		$criteria->compare('UpdateAt', $this->UpdateAt, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}