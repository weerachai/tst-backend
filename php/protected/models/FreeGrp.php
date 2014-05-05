<?php

Yii::import('application.models._base.BaseFreeGrp');

class FreeGrp extends BaseFreeGrp
{
	public $GrpLevel1Id;
	public $GrpLevel2Id;
	public $GrpLevel3Id;
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
			'GrpLevel1Id' => Yii::t('app', 'กลุ่มใหญ่'),
			'GrpLevel2Id' => Yii::t('app', 'กลุ่มกลาง'),
			'GrpLevel3Id' => Yii::t('app', 'กลุ่มย่อย'),
			'ProductId' => Yii::t('app', 'ชื่อสินค้า'),
			'FreePack' => Yii::t('app', 'หน่วย'),
		);
	}
}