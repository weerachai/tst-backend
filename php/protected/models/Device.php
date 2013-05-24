<?php

/**
 * This is the model class for table "Device".
 *
 * The followings are the available columns in table 'Device':
 * @property string $DeviceId
 * @property string $DeviceKey
 * @property string $SaleId
 * @property string $Username
 * @property string $Password
 * @property string $UpdateAt
 *
 * The followings are the available model relations:
 * @property SaleUnit $sale
 */
class Device extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Device the static model class
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
		return 'Device';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('DeviceId, DeviceKey, SaleId, Username, Password', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('DeviceId, DeviceKey, SaleId, Username, Password, UpdateAt', 'safe', 'on'=>'search'),
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
			'sale' => array(self::BELONGS_TO, 'SaleUnit', 'SaleId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'DeviceId' => 'Device',
			'DeviceKey' => 'Device Key',
			'SaleId' => 'Sale',
			'Username' => 'Username',
			'Password' => 'Password',
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

		$criteria->compare('DeviceId',$this->DeviceId,true);
		$criteria->compare('DeviceKey',$this->DeviceKey,true);
		$criteria->compare('SaleId',$this->SaleId,true);
		$criteria->compare('Username',$this->Username,true);
		$criteria->compare('Password',$this->Password,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}