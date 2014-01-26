<?php

Yii::import('application.models._base.BaseControlNo');

class ControlNo extends BaseControlNo
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'saleUnit' => array(self::BELONGS_TO, 'SaleUnit', 'SaleId'),
			'control' => array(self::BELONGS_TO, 'ControlRunning', 'ControlId'),
		);
	}

	public function rules() {
		return array(
			array('SaleId, ControlId, Year, Month, No', 'required'),
			array('Year, Month, No', 'numerical', 'integerOnly'=>true, 'min'=>1, 'max'=>9999),
			array('SaleId, ControlId', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			array('UpdateAt', 'default', 'setOnEmpty' => true, 'value' => null),
			array('SaleId, ControlId, Year, Month, No, UpdateAt', 'safe', 'on'=>'search'),
		);
	}

	public static function getControlNo($saleId, $name)
	{
		$sql = <<<SQL
			SELECT Prefix, Year, Month, No 
			FROM ControlNo JOIN ControlRunning USING(ControlId) 
			WHERE SaleId = '$saleId' 
			AND ControlName = '$name-backend'
SQL;

		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($rawData as $row) {
			if ($row['Year'] != date("y") || $row['Month'] != date("n")) {
				$id = $row['Prefix'].$saleId.date("ym").'0001';
				$y = date("y");
				$m = date('n');
				$sql = <<<SQL
					UPDATE ControlNo SET Year = $y, Month = $m, No = 1
					WHERE SaleId = '$saleId' 
					AND ControlId IN 
					(SELECT ControlId FROM ControlRunning WHERE ControlName = '$name-backend')
SQL;
				Yii::app()->db->createCommand($sql)->execute();
			} else
				$id = $row['Prefix'].$saleId.sprintf("%02d",$row['Year']).sprintf("%02d",$row['Month']).sprintf("%04d",$row['No']);
			break;
		}
		return $id;
	}

	public static function updateControlNo($saleId, $name)
	{
		$sql = <<<SQL
			UPDATE ControlNo SET No = No + 1
			WHERE SaleId = '$saleId' 
			AND ControlId IN 
			(SELECT ControlId FROM ControlRunning WHERE ControlName = '$name-backend')
SQL;
		Yii::app()->db->createCommand($sql)->execute();
	}
}