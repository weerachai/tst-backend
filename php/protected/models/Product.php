<?php

Yii::import('application.models._base.BaseProduct');

class Product extends BaseProduct
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public static function getOptions() {
		return CHtml::listData(Product::model()->findAll(), 
				'ProductId', 'ProductName'
			);
	}

	public static function getGroupLevel1() {
		$data = GrpLevel1::model()->findAll(array(
				'select'=>'GrpLevel1Id, GrpLevel1Name',
				'distinct'=>true
				));
		return CHtml::listData($data,'GrpLevel1Id','GrpLevel1Name');
	}

	public static function getGroupLevel2() {
		$data = GrpLevel2::model()->findAll(array(
				'select'=>'GrpLevel2Id, GrpLevel2Name',
				'distinct'=>true
				));
		return CHtml::listData($data,'GrpLevel2Id','GrpLevel2Name');
	}

	public static function getGroupLevel3() {
		$data = GrpLevel3::model()->findAll(array(
				'select'=>'GrpLevel3Id, GrpLevel3Name',
				'distinct'=>true
				));
		return CHtml::listData($data,'GrpLevel3Id','GrpLevel3Name');
	}

	public static function getPacks() {
		$data = Product::model()->findAll(array(
				'select'=>'PackLevel1',
				'distinct'=>true,
				'condition'=>'PackLevel1 IS NOT NULL AND length(trim(PackLevel1)) > 0'
				));
		$list = CHtml::listData($data,'PackLevel1','PackLevel1');

		$data = Product::model()->findAll(array(
				'select'=>'PackLevel2',
				'distinct'=>true,
				'condition'=>'PackLevel2 IS NOT NULL AND length(trim(PackLevel2)) > 0'
				));
		$list = array_merge($list,CHtml::listData($data,'PackLevel2','PackLevel2'));

		$data = Product::model()->findAll(array(
				'select'=>'PackLevel3',
				'distinct'=>true,
				'condition'=>'PackLevel3 IS NOT NULL AND length(trim(PackLevel3)) > 0'
				));
		$list = array_merge($list,CHtml::listData($data,'PackLevel3','PackLevel3'));

		$data = Product::model()->findAll(array(
				'select'=>'PackLevel4',
				'distinct'=>true,
				'condition'=>'PackLevel4 IS NOT NULL AND length(trim(PackLevel4)) > 0'
				));
		return array_merge($list,CHtml::listData($data,'PackLevel4','PackLevel4'));
	}
}