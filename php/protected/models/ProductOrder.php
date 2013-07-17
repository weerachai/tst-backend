<?php

Yii::import('application.models._base.BaseProductOrder');

class ProductOrder extends BaseProductOrder
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}