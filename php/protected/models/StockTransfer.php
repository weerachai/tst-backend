<?php

Yii::import('application.models._base.BaseStockTransfer');

class StockTransfer extends BaseStockTransfer
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}