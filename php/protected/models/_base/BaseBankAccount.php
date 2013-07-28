<?php

/**
 * This is the model base class for the table "BankAccount".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "BankAccount".
 *
 * Columns in table "BankAccount" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $BankId
 * @property string $Bank
 * @property string $Branch
 * @property string $AccountNo
 * @property string $UpdateAt
 *
 */
abstract class BaseBankAccount extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'BankAccount';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'BankAccount|BankAccounts', $n);
	}

	public static function representingColumn() {
		return 'Bank';
	}

	public function rules() {
		return array(
			array('Bank, Branch, AccountNo', 'required'),
			array('Bank, Branch, AccountNo', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			array('UpdateAt', 'default', 'setOnEmpty' => true, 'value' => null),
			array('BankId, Bank, Branch, AccountNo, UpdateAt', 'safe', 'on'=>'search'),
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
			'BankId' => Yii::t('app', 'Bank'),
			'Bank' => Yii::t('app', 'Bank'),
			'Branch' => Yii::t('app', 'Branch'),
			'AccountNo' => Yii::t('app', 'Account No'),
			'UpdateAt' => Yii::t('app', 'Update At'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('BankId', $this->BankId);
		$criteria->compare('Bank', $this->Bank, true);
		$criteria->compare('Branch', $this->Branch, true);
		$criteria->compare('AccountNo', $this->AccountNo, true);
		$criteria->compare('UpdateAt', $this->UpdateAt, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}