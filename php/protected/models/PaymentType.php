<?php

Yii::import('application.models._base.BasePaymentType');

class PaymentType extends BasePaymentType
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}