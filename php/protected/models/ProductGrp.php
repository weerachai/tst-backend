<?php

Yii::import('application.models._base.BaseProductGrp');

class ProductGrp extends BaseProductGrp
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function rules() {
		return array(
			array('ProductGrpId, ProductId', 'required'),
			array('ProductGrpId+ProductId', 'application.extensions.uniqueMultiColumnValidator'),
			array('ProductGrpId, ProductId', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			array('UpdateAt', 'default', 'setOnEmpty' => true, 'value' => null),
			array('ProductGrpId, ProductId, UpdateAt', 'safe', 'on'=>'search'),
		);
	}

	public function attributeLabels() {
		return array(
			'ProductGrpId' => Yii::t('app', 'รหัสกลุ่มสินค้า'),
			'ProductId' => Yii::t('app', 'รหัสสินค้า'),
		);
	}
}