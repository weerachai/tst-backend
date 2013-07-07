<?php

/**
 * This is the model class for table "Warehouse".
 *
 * The followings are the available columns in table 'Warehouse':
 * @property string $WarehouseId
 * @property string $WarehouseName
 * @property string $WarehouseType
 * @property string $UpdateAt
 */
class Warehouse extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Warehouse the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Warehouse';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('WarehouseId, WarehouseName, WarehouseType', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('WarehouseId, WarehouseName, WarehouseType, UpdateAt', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'WarehouseId' => 'Warehouse',
			'WarehouseName' => 'Warehouse Name',
			'WarehouseType' => 'Warehouse Type',
			'UpdateAt' => 'Update At',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('WarehouseId',$this->WarehouseId,true);
		$criteria->compare('WarehouseName',$this->WarehouseName,true);
		$criteria->compare('WarehouseType',$this->WarehouseType,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}