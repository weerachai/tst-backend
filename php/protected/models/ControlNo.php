<?php

/**
 * This is the model class for table "ControlNo".
 *
 * The followings are the available columns in table 'ControlNo':
 * @property string $SaleId
 * @property string $ControlId
 * @property integer $Year
 * @property integer $Month
 * @property integer $No
 * @property string $UpdateAt
 */
class ControlNo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ControlNo the static model class
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
		return 'ControlNo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Year, Month, No', 'numerical', 'integerOnly'=>true),
			array('SaleId, ControlId', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('SaleId, ControlId, Year, Month, No, UpdateAt', 'safe', 'on'=>'search'),
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
			'SaleId' => 'Sale',
			'ControlId' => 'Control',
			'Year' => 'Year',
			'Month' => 'Month',
			'No' => 'No',
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

		$criteria->compare('SaleId',$this->SaleId,true);
		$criteria->compare('ControlId',$this->ControlId,true);
		$criteria->compare('Year',$this->Year);
		$criteria->compare('Month',$this->Month);
		$criteria->compare('No',$this->No);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}