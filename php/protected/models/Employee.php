<?php

Yii::import('application.models._base.BaseEmployee');

class Employee extends BaseEmployee
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public static function representingColumn() {
		return array('FirstName', 'LastName');
	}

	public function relations() {
		return array(
			'saleArea' => array(self::BELONGS_TO, 'SaleArea', 'SupervisorId'),
			'saleUnit' => array(self::HAS_ONE, 'SaleUnit', 'EmployeeId'),
			'user' => array(self::HAS_ONE, 'User', 'employee'),
		);
	}

	public function attributeLabels() {
		return array(
			'EmployeeId' => Yii::t('app', 'รหัสพนักงาน'),
			'FirstName' => Yii::t('app', 'ชื่อ'),
			'LastName' => Yii::t('app', 'นามสกุล'),
			'Active' => Yii::t('app', 'Active'),
		);
	}

	public function rules() {
		return array(
			array('EmployeeId, FirstName, LastName', 'required'),
			array('EmployeeId, FirstName, LastName', 'length', 'max'=>255),
			array('EmployeeId', 'unique'),
			array('FirstName+LastName', 'application.extensions.uniqueMultiColumnValidator'),
			array('EmployeeId, FirstName, LastName', 'safe', 'on'=>'search'),
		);
	}

	public static function getOptions() {
		return CHtml::listData(Employee::model()->findAll(), 
				'EmployeeId', 
				function($row) {
					return CHtml::encode($row->FirstName.' '.$row->LastName);
				}
			);
	}

	public static function getAvailableOptions() {
		return CHtml::listData(Employee::model()->with('saleUnit')->findAll('SaleId IS NULL'), 
				'EmployeeId', 
				function($row) {
					return CHtml::encode($row->FirstName.' '.$row->LastName);
				}
			);
	}

	public static function getAssignedOptions() {
		return CHtml::listData(Employee::model()->with('saleUnit')->findAll('SaleId IS NOT NULL'), 
				'saleUnit.SaleId', 
				function($row) {
					return CHtml::encode($row->FirstName.' '.$row->LastName);
				}
			);
	}	

	public static function getNoAccountOptions($id) {
		if (empty($id))
			$id = -1;
		return array(''=>'-')+CHtml::listData(Employee::model()->with('user')->findAll('username IS NULL OR EmployeeId = ?', array($id)), 
				'EmployeeId', 
				function($row) {
					return CHtml::encode($row->FirstName.' '.$row->LastName);
				}
			);
	}
}