<?php

Yii::import('application.models._base.BaseDevice');

class Device extends BaseDevice
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}