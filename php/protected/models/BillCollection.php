<?php

Yii::import('application.models._base.BaseBillCollection');

class BillCollection extends BaseBillCollection
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}