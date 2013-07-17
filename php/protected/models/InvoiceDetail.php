<?php

Yii::import('application.models._base.BaseInvoiceDetail');

class InvoiceDetail extends BaseInvoiceDetail
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}