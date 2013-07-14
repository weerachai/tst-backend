<?php

Yii::import('application.models._base.BaseLocation');

class Location extends BaseLocation
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public static function getProvinces() {
		$data = Location::model()->findAll(array(
				'select'=>'Province',
				'distinct'=>true
				));
		return CHtml::listData($data,'Province','Province');
	}

	public static function getDistricts($province) {
		$data = Location::model()->findAll(array(
				'select'=>'District',
				'distinct'=>true,
				'condition'=>'Province=:Province',
				'params'=>array(':Province'=>$province)
				));
		return CHtml::listData($data,'District','District'); 
	}

	public static function getSubDistricts($province,$district) {
		$data = Location::model()->findAll(array(
				'select'=>'SubDistrict',
				'distinct'=>true,
				'condition'=>'Province=:Province AND District=:District',
				'params'=>array(':Province'=>$province,':District'=>$district)
				));
		return CHtml::listData($data,'SubDistrict','SubDistrict');
	}
}