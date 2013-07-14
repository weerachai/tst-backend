<?php

Yii::import('application.models._base.BaseSaleUnit');

class SaleUnit extends BaseSaleUnit
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public static function getOptions() {
		return CHtml::listData(SaleUnit::model()->findAll(), 
				'SaleId', 'SaleName'
			);
	}
}