<?php

/**
 * This is the model base class for the table "ControlRunning".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ControlRunning".
 *
 * Columns in table "ControlRunning" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $ControlId
 * @property string $ControlName
 * @property string $Prefix
 *
 */
abstract class BaseControlRunning extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'ControlRunning';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'ControlRunning|ControlRunnings', $n);
	}

	public static function representingColumn() {
		return 'ControlName';
	}

	public function rules() {
		return array(
			array('ControlName, Prefix', 'required'),
			array('ControlId, ControlName, Prefix', 'length', 'max'=>255),
			array('ControlId', 'default', 'setOnEmpty' => true, 'value' => null),
			array('ControlId, ControlName, Prefix', 'safe', 'on'=>'search'),
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
			'ControlId' => Yii::t('app', 'Control'),
			'ControlName' => Yii::t('app', 'Control Name'),
			'Prefix' => Yii::t('app', 'Prefix'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('ControlId', $this->ControlId, true);
		$criteria->compare('ControlName', $this->ControlName, true);
		$criteria->compare('Prefix', $this->Prefix, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}