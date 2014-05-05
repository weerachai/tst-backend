<?php

Yii::import('application.models._base.BaseProductGrp');

class ProductGrp extends BaseProductGrp
{
	public $GrpLevel1Id;
	public $GrpLevel2Id;
	public $GrpLevel3Id;
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
			'GrpLevel1Id' => Yii::t('app', 'กลุ่มใหญ่'),
			'GrpLevel2Id' => Yii::t('app', 'กลุ่มกลาง'),
			'GrpLevel3Id' => Yii::t('app', 'กลุ่มย่อย'),
			'ProductId' => Yii::t('app', 'ชื่อสินค้า'),
		);
	}
}