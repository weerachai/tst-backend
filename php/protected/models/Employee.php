<?php

Yii::import('application.models._base.BaseEmployee');

class Employee extends BaseEmployee
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public static function getOptions() {
		return CHtml::listData(Employee::model()->findAll(), 
				'EmployeeId', 
				function($row) {
					return CHtml::encode($row->FirstName.' '.$row->LastName);
				}
			);
	}
}