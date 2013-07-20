<?php

Yii::import('application.models._base.BaseTrip');

class Trip extends BaseTrip
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public static function getOptions() {
		return CHtml::listData(Trip::model()->findAll(), 
				'TripName', 'TripName'
			);
	}
}