<?php

Yii::import('application.models._base.BaseStockCheck');

class StockCheck extends BaseStockCheck
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}