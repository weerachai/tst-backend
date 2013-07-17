<?php

Yii::import('application.models._base.BaseInvoicePayment');

class InvoicePayment extends BaseInvoicePayment
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}