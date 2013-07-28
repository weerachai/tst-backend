<?php

/**
 * This is the model base class for the table "ControlNo".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ControlNo".
 *
 * Columns in table "ControlNo" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $SaleId
 * @property string $ControlId
 * @property integer $Year
 * @property integer $Month
 * @property integer $No
 * @property string $UpdateAt
 *
 */
abstract class BaseControlNo extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'ControlNo';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'ControlNo|ControlNos', $n);
	}

	public static function representingColumn() {
		return 'SaleId';
	}

	public function rules() {
		return array(
			array('SaleId, ControlId, Year, Month, No', 'required'),
			array('Year, Month, No', 'numerical', 'integerOnly'=>true),
			array('SaleId, ControlId', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			array('UpdateAt', 'default', 'setOnEmpty' => true, 'value' => null),
			array('SaleId, ControlId, Year, Month, No, UpdateAt', 'safe', 'on'=>'search'),
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
			'ControlId' => Yii::t('app', 'Control'),
			'Year' => Yii::t('app', 'Year'),
			'Month' => Yii::t('app', 'Month'),
			'No' => Yii::t('app', 'No'),
			'UpdateAt' => Yii::t('app', 'Update At'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('SaleId', $this->SaleId, true);
		$criteria->compare('ControlId', $this->ControlId, true);
		$criteria->compare('Year', $this->Year);
		$criteria->compare('Month', $this->Month);
		$criteria->compare('No', $this->No);
		$criteria->compare('UpdateAt', $this->UpdateAt, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}