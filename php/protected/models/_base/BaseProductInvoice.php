<?php

/**
 * This is the model base class for the table "ProductInvoice".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ProductInvoice".
 *
 * Columns in table "ProductInvoice" available as properties of the model,
 * followed by relations of table "ProductInvoice" available as properties of the model.
 *
 * @property string $InvoiceNo
 * @property string $OrderNo
 * @property string $SaleId
 * @property string $InvoiceDate
 * @property string $DueDate
 * @property string $Total
 * @property string $Paid
 * @property string $Status
 * @property string $UpdateAt
 *
 * @property InvoiceDetail[] $invoiceDetails
 */
abstract class BaseProductInvoice extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'ProductInvoice';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'ProductInvoice|ProductInvoices', $n);
	}

	public static function representingColumn() {
		return 'InvoiceNo';
	}

	public function rules() {
		return array(
			array('InvoiceNo, OrderNo, SaleId, Status', 'length', 'max'=>255),
			array('Total, Paid', 'length', 'max'=>20),
			array('InvoiceDate, DueDate, UpdateAt', 'safe'),
			array('InvoiceNo, OrderNo, SaleId, InvoiceDate, DueDate, Total, Paid, Status, UpdateAt', 'default', 'setOnEmpty' => true, 'value' => null),
			array('InvoiceNo, OrderNo, SaleId, InvoiceDate, DueDate, Total, Paid, Status, UpdateAt', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'invoiceDetails' => array(self::HAS_MANY, 'InvoiceDetail', 'InvoiceNo'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'InvoiceNo' => Yii::t('app', 'Invoice No'),
			'OrderNo' => Yii::t('app', 'Order No'),
			'SaleId' => Yii::t('app', 'Sale'),
			'InvoiceDate' => Yii::t('app', 'Invoice Date'),
			'DueDate' => Yii::t('app', 'Due Date'),
			'Total' => Yii::t('app', 'Total'),
			'Paid' => Yii::t('app', 'Paid'),
			'Status' => Yii::t('app', 'Status'),
			'UpdateAt' => Yii::t('app', 'Update At'),
			'invoiceDetails' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('InvoiceNo', $this->InvoiceNo, true);
		$criteria->compare('OrderNo', $this->OrderNo, true);
		$criteria->compare('SaleId', $this->SaleId, true);
		$criteria->compare('InvoiceDate', $this->InvoiceDate, true);
		$criteria->compare('DueDate', $this->DueDate, true);
		$criteria->compare('Total', $this->Total, true);
		$criteria->compare('Paid', $this->Paid, true);
		$criteria->compare('Status', $this->Status, true);
		$criteria->compare('UpdateAt', $this->UpdateAt, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}