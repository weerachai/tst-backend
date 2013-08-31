<?php

Yii::import('application.models._base.BaseSyncLog');

class SyncLog extends BaseSyncLog
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}