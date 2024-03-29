<?php

/**
 * This is the model base class for the table "Warehouse".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Warehouse".
 *
 * Columns in table "Warehouse" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $WarehouseId
 * @property string $WarehouseName
 * @property string $WarehouseType
 * @property string $UpdateAt
 *
 */
abstract class BaseWarehouse extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'Warehouse';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Warehouse|Warehouses', $n);
	}

	public static function representingColumn() {
		return 'WarehouseName';
	}

	public function rules() {
		return array(
			array('WarehouseId, WarehouseName, WarehouseType', 'required'),
			array('WarehouseId, WarehouseName, WarehouseType', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			array('UpdateAt', 'default', 'setOnEmpty' => true, 'value' => null),
			array('WarehouseId, WarehouseName, WarehouseType, UpdateAt', 'safe', 'on'=>'search'),
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
			'WarehouseId' => Yii::t('app', 'Warehouse'),
			'WarehouseName' => Yii::t('app', 'Warehouse Name'),
			'WarehouseType' => Yii::t('app', 'Warehouse Type'),
			'UpdateAt' => Yii::t('app', 'Update At'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('WarehouseId', $this->WarehouseId, true);
		$criteria->compare('WarehouseName', $this->WarehouseName, true);
		$criteria->compare('WarehouseType', $this->WarehouseType, true);
		$criteria->compare('UpdateAt', $this->UpdateAt, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}