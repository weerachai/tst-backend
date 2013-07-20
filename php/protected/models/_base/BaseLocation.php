<?php

/**
 * This is the model base class for the table "Location".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Location".
 *
 * Columns in table "Location" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $LocationId
 * @property string $Province
 * @property string $District
 * @property string $SubDistrict
 * @property string $ZipCode
 *
 */
abstract class BaseLocation extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'Location';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Location|Locations', $n);
	}

	public static function representingColumn() {
		return 'LocationId';
	}

	public function rules() {
		return array(
			array('LocationId, Province, District, SubDistrict, ZipCode', 'length', 'max'=>255),
			array('LocationId, Province, District, SubDistrict, ZipCode', 'default', 'setOnEmpty' => true, 'value' => null),
			array('LocationId, Province, District, SubDistrict, ZipCode', 'safe', 'on'=>'search'),
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
			'LocationId' => Yii::t('app', 'Location'),
			'Province' => Yii::t('app', 'Province'),
			'District' => Yii::t('app', 'District'),
			'SubDistrict' => Yii::t('app', 'Sub District'),
			'ZipCode' => Yii::t('app', 'Zip Code'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('LocationId', $this->LocationId, true);
		$criteria->compare('Province', $this->Province, true);
		$criteria->compare('District', $this->District, true);
		$criteria->compare('SubDistrict', $this->SubDistrict, true);
		$criteria->compare('ZipCode', $this->ZipCode, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}