<?php

/**
 * This is the model base class for the table "Config".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Config".
 *
 * Columns in table "Config" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property integer $DayToClear
 * @property integer $SaleDiffPercent
 * @property integer $StockDiffPercent
 * @property string $UpdateAt
 *
 */
abstract class BaseConfig extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'Config';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Config|Configs', $n);
	}

	public static function representingColumn() {
		return 'UpdateAt';
	}

	public function rules() {
		return array(
			array('DayToClear', 'required'),
			array('DayToClear, SaleDiffPercent, StockDiffPercent', 'numerical', 'integerOnly'=>true),
			array('UpdateAt', 'safe'),
			array('SaleDiffPercent, StockDiffPercent, UpdateAt', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, DayToClear, SaleDiffPercent, StockDiffPercent, UpdateAt', 'safe', 'on'=>'search'),
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
			'id' => Yii::t('app', 'ID'),
			'DayToClear' => Yii::t('app', 'Day To Clear'),
			'SaleDiffPercent' => Yii::t('app', 'Sale Diff Percent'),
			'StockDiffPercent' => Yii::t('app', 'Stock Diff Percent'),
			'UpdateAt' => Yii::t('app', 'Update At'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('DayToClear', $this->DayToClear);
		$criteria->compare('SaleDiffPercent', $this->SaleDiffPercent);
		$criteria->compare('StockDiffPercent', $this->StockDiffPercent);
		$criteria->compare('UpdateAt', $this->UpdateAt, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}