<?php

Yii::import('application.models._base.BaseStockCheckList');

class StockCheckList extends BaseStockCheckList
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}