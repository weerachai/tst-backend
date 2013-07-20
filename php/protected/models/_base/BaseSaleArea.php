<?php

/**
 * This is the model base class for the table "SaleArea".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "SaleArea".
 *
 * Columns in table "SaleArea" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $AreaId
 * @property string $AreaName
 * @property string $Province
 * @property string $District
 * @property string $SubDistrict
 * @property string $SupervisorId
 *
 */
abstract class BaseSaleArea extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'SaleArea';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'SaleArea|SaleAreas', $n);
	}

	public static function representingColumn() {
		return 'AreaName';
	}

	public function rules() {
		return array(
			array('AreaId, AreaName, Province, District, SubDistrict', 'required'),
			array('AreaId, AreaName, Province, District, SubDistrict, SupervisorId', 'length', 'max'=>255),
			array('SupervisorId', 'default', 'setOnEmpty' => true, 'value' => null),
			array('AreaId, AreaName, Province, District, SubDistrict, SupervisorId', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'AreaId' => Yii::t('app', 'Area'),
			'AreaName' => Yii::t('app', 'Area Name'),
			'Province' => Yii::t('app', 'Province'),
			'District' => Yii::t('app', 'District'),
			'SubDistrict' => Yii::t('app', 'Sub District'),
			'SupervisorId' => Yii::t('app', 'Supervisor'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('AreaId', $this->AreaId, true);
		$criteria->compare('AreaName', $this->AreaName, true);
		$criteria->compare('Province', $this->Province, true);
		$criteria->compare('District', $this->District, true);
		$criteria->compare('SubDistrict', $this->SubDistrict, true);
		$criteria->compare('SupervisorId', $this->SupervisorId, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}