<?php

Yii::import('application.models._base.BaseSaleHistory');

class SaleHistory extends BaseSaleHistory
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}