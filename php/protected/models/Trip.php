<?php

Yii::import('application.models._base.BaseTrip');

class Trip extends BaseTrip
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public static function getOptions($type) {
		if ($type == 'm')
			return CHtml::listData(Trip::model()->findAll('TripId > 7'), 
				'TripName', 'TripName'
			);
		else if ($type == 'w')
			return CHtml::listData(Trip::model()->findAll('TripId <= 7'), 
				'TripName', 'TripName'
			);
		else
			return CHtml::listData(Trip::model()->findAll(), 
				'TripName', 'TripName'
			);
	}
}