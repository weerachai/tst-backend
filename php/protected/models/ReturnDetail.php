<?php

Yii::import('application.models._base.BaseReturnDetail');

class ReturnDetail extends BaseReturnDetail
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