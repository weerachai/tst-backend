<?php

Yii::import('application.models._base.BaseWarehouse');

class Warehouse extends BaseWarehouse
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}