<?php

Yii::import('application.models._base.BaseProductReturn');

class ProductReturn extends BaseProductReturn
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}