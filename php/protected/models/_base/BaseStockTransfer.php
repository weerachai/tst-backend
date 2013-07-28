<?php

/**
 * This is the model base class for the table "StockTransfer".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "StockTransfer".
 *
 * Columns in table "StockTransfer" available as properties of the model,
 * followed by relations of table "StockTransfer" available as properties of the model.
 *
 * @property string $TransferNo
 * @property string $SaleId
 * @property string $WarehouseId
 * @property string $WarehouseName
 * @property string $WarehouseType
 * @property string $TransferDate
 * @property string $Total
 * @property string $Status
 * @property string $UpdateAt
 *
 * @property TransferDetail[] $transferDetails
 */
abstract class BaseStockTransfer extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'StockTransfer';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'StockTransfer|StockTransfers', $n);
	}

	public static function representingColumn() {
		return 'TransferNo';
	}

	public function rules() {
		return array(
			array('TransferNo, SaleId, WarehouseId, WarehouseName, WarehouseType, Status', 'length', 'max'=>255),
			array('Total', 'length', 'max'=>10),
			array('TransferDate, UpdateAt', 'safe'),
			array('TransferNo, SaleId, WarehouseId, WarehouseName, WarehouseType, TransferDate, Total, Status, UpdateAt', 'default', 'setOnEmpty' => true, 'value' => null),
			array('TransferNo, SaleId, WarehouseId, WarehouseName, WarehouseType, TransferDate, Total, Status, UpdateAt', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'transferDetails' => array(self::HAS_MANY, 'TransferDetail', 'TransferNo'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'TransferNo' => Yii::t('app', 'Transfer No'),
			'SaleId' => Yii::t('app', 'Sale'),
			'WarehouseId' => Yii::t('app', 'Warehouse'),
			'WarehouseName' => Yii::t('app', 'Warehouse Name'),
			'WarehouseType' => Yii::t('app', 'Warehouse Type'),
			'TransferDate' => Yii::t('app', 'Transfer Date'),
			'Total' => Yii::t('app', 'Total'),
			'Status' => Yii::t('app', 'Status'),
			'UpdateAt' => Yii::t('app', 'Update At'),
			'transferDetails' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('TransferNo', $this->TransferNo, true);
		$criteria->compare('SaleId', $this->SaleId, true);
		$criteria->compare('WarehouseId', $this->WarehouseId, true);
		$criteria->compare('WarehouseName', $this->WarehouseName, true);
		$criteria->compare('WarehouseType', $this->WarehouseType, true);
		$criteria->compare('TransferDate', $this->TransferDate, true);
		$criteria->compare('Total', $this->Total, true);
		$criteria->compare('Status', $this->Status, true);
		$criteria->compare('UpdateAt', $this->UpdateAt, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}