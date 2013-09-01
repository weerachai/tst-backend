<?php

/**
 * This is the model base class for the table "RequestIR".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "RequestIR".
 *
 * Columns in table "RequestIR" available as properties of the model,
 * followed by relations of table "RequestIR" available as properties of the model.
 *
 * @property string $IRNo
 * @property string $RequestNo
 * @property string $UpdateAt
 *
 * @property StockIR $iRNo
 */
abstract class BaseRequestIR extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'RequestIR';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'RequestIR|RequestIRs', $n);
	}

	public static function representingColumn() {
		return 'RequestNo';
	}

	public function rules() {
		return array(
			array('IRNo, RequestNo', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			array('IRNo, RequestNo, UpdateAt', 'default', 'setOnEmpty' => true, 'value' => null),
			array('IRNo, RequestNo, UpdateAt', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'iRNo' => array(self::BELONGS_TO, 'StockIR', 'IRNo'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'IRNo' => null,
			'RequestNo' => Yii::t('app', 'Request No'),
			'UpdateAt' => Yii::t('app', 'Update At'),
			'iRNo' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('IRNo', $this->IRNo);
		$criteria->compare('RequestNo', $this->RequestNo, true);
		$criteria->compare('UpdateAt', $this->UpdateAt, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}