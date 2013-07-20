<?php

/**
 * This is the model base class for the table "SaleUnit".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "SaleUnit".
 *
 * Columns in table "SaleUnit" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $SaleId
 * @property string $SaleName
 * @property string $SaleType
 * @property string $EmployeeId
 * @property string $AreaId
 * @property string $Active
 *
 */
abstract class BaseSaleUnit extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'SaleUnit';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'SaleUnit|SaleUnits', $n);
	}

	public static function representingColumn() {
		return 'SaleName';
	}

	public function rules() {
		return array(
			array('SaleId, SaleName, SaleType, Active', 'required'),
			array('SaleId, SaleName, SaleType, EmployeeId, AreaId, Active', 'length', 'max'=>255),
			array('EmployeeId, AreaId', 'default', 'setOnEmpty' => true, 'value' => null),
			array('SaleId, SaleName, SaleType, EmployeeId, AreaId, Active', 'safe', 'on'=>'search'),
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
			'SaleName' => Yii::t('app', 'Sale Name'),
			'SaleType' => Yii::t('app', 'Sale Type'),
			'EmployeeId' => Yii::t('app', 'Employee'),
			'AreaId' => Yii::t('app', 'Area'),
			'Active' => Yii::t('app', 'Active'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('SaleId', $this->SaleId, true);
		$criteria->compare('SaleName', $this->SaleName, true);
		$criteria->compare('SaleType', $this->SaleType, true);
		$criteria->compare('EmployeeId', $this->EmployeeId, true);
		$criteria->compare('AreaId', $this->AreaId, true);
		$criteria->compare('Active', $this->Active, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}