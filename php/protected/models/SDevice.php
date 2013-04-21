<?php

/**
 * This is the model class for table "sDevice".
 *
 * The followings are the available columns in table 'sDevice':
 * @property string $DeviceId
 * @property string $DeviceKey
 * @property string $SaleId
 * @property string $Username
 * @property string $Password
 *
 * The followings are the available model relations:
 * @property BSaleUnit $sale
 */
class SDevice extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SDevice the static model class
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
		return 'sDevice';
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
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('DeviceId, DeviceKey, SaleId, Username, Password', 'safe', 'on'=>'search'),
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
			'sale' => array(self::BELONGS_TO, 'BSaleUnit', 'SaleId'),
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}