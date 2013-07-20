<?php

/**
 * This is the model base class for the table "Employee".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Employee".
 *
 * Columns in table "Employee" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $EmployeeId
 * @property string $FirstName
 * @property string $LastName
 * @property string $Active
 *
 */
abstract class BaseEmployee extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'Employee';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Employee|Employees', $n);
	}

	public static function representingColumn() {
		return 'FirstName';
	}

	public function rules() {
		return array(
			array('EmployeeId, FirstName, LastName, Active', 'required'),
			array('EmployeeId, FirstName, LastName', 'length', 'max'=>255),
			array('Active', 'length', 'max'=>1),
			array('EmployeeId, FirstName, LastName, Active', 'safe', 'on'=>'search'),
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
			'EmployeeId' => Yii::t('app', 'Employee'),
			'FirstName' => Yii::t('app', 'First Name'),
			'LastName' => Yii::t('app', 'Last Name'),
			'Active' => Yii::t('app', 'Active'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('EmployeeId', $this->EmployeeId, true);
		$criteria->compare('FirstName', $this->FirstName, true);
		$criteria->compare('LastName', $this->LastName, true);
		$criteria->compare('Active', $this->Active, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}