<?php

Yii::import('application.models._base.BaseDeliverDetail');

class DeliverDetail extends BaseDeliverDetail
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'product' => array(self::BELONGS_TO, 'Product', 'ProductId'),
		);
	}
}