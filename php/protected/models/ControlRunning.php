<?php

Yii::import('application.models._base.BaseControlRunning');

class ControlRunning extends BaseControlRunning
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'controlNos' => array(self::HAS_MANY, 'ControlNo', 'ControlId'),
		);
	}
}