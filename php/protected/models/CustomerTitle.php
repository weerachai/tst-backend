<?php

Yii::import('application.models._base.BaseCustomerTitle');

class CustomerTitle extends BaseCustomerTitle
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public static function getOptions() {
		return CHtml::listData(CustomerTitle::model()->findAll(), 
				'CustomerTitle', 'CustomerTitle'
			);
	}
}