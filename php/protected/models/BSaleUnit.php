<?php

/**
 * This is the model class for table "bSaleUnit".
 *
 * The followings are the available columns in table 'bSaleUnit':
 * @property string $SaleId
 * @property string $SaleName
 * @property string $SaleType
 * @property string $EmployeeId
 * @property string $AreaId
 * @property string $Active
 *
 * The followings are the available model relations:
 * @property BSaleArea $area
 * @property BEmployee $employee
 * @property CDeviceSetting $cDeviceSetting
 * @property SDevice[] $sDevices
 */
class BSaleUnit extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BSaleUnit the static model class
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
		return 'bSaleUnit';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('SaleName', 'required'),
			array('SaleId, SaleName, SaleType, EmployeeId, AreaId, Active', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('SaleId, SaleName, SaleType, EmployeeId, AreaId, Active', 'safe', 'on'=>'search'),
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
			'area' => array(self::BELONGS_TO, 'BSaleArea', 'AreaId'),
			'employee' => array(self::BELONGS_TO, 'BEmployee', 'EmployeeId'),
			'cDeviceSetting' => array(self::HAS_ONE, 'CDeviceSetting', 'SaleId'),
			'sDevices' => array(self::HAS_MANY, 'SDevice', 'SaleId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'SaleId' => 'Sale',
			'SaleName' => 'Sale Name',
			'SaleType' => 'Sale Type',
			'EmployeeId' => 'Employee',
			'AreaId' => 'Area',
			'Active' => 'Active',
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

		$criteria->compare('SaleId',$this->SaleId,true);
		$criteria->compare('SaleName',$this->SaleName,true);
		$criteria->compare('SaleType',$this->SaleType,true);
		$criteria->compare('EmployeeId',$this->EmployeeId,true);
		$criteria->compare('AreaId',$this->AreaId,true);
		$criteria->compare('Active',$this->Active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}