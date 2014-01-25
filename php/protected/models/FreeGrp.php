<?php

Yii::import('application.models._base.BaseFreeGrp');

class FreeGrp extends BaseFreeGrp
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function rules() {
		return array(
			array('FreeGrpId, ProductId, FreePack', 'required'),
			array('FreeGrpId+ProductId', 'application.extensions.uniqueMultiColumnValidator'),
			array('FreeGrpId, ProductId, FreePack', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			array('UpdateAt', 'default', 'setOnEmpty' => true, 'value' => null),
			array('FreeGrpId, ProductId, FreePack, UpdateAt', 'safe', 'on'=>'search'),
		);
	}

	public function attributeLabels() {
		return array(
			'FreeGrpId' => Yii::t('app', 'รหัสกลุ่มสินค้าแถม'),
			'ProductId' => Yii::t('app', 'รหัสสินค้า'),
			'FreePack' => Yii::t('app', 'หน่วย'),
		);
	}
}