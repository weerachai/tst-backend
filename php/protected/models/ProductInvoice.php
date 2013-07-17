<?php

Yii::import('application.models._base.BaseProductInvoice');

class ProductInvoice extends BaseProductInvoice
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}