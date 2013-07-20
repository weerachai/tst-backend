<?php

Yii::import('application.models._base.BaseBankAccount');

class BankAccount extends BaseBankAccount
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}