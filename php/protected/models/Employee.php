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
}