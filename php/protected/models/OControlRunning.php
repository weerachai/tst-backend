<?php

/**
 * This is the model class for table "oControlRunning".
 *
 * The followings are the available columns in table 'oControlRunning':
 * @property string $ControlId
 * @property string $ControlName
 * @property string $Prefix
 * @property string $UpdateAt
 */
class OControlRunning extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OControlRunning the static model class
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
		return 'oControlRunning';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ControlName, Prefix', 'required'),
			array('ControlId, ControlName, Prefix', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ControlId, ControlName, Prefix, UpdateAt', 'safe', 'on'=>'search'),
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
			'ControlId' => 'Control',
			'ControlName' => 'Control Name',
			'Prefix' => 'Prefix',
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

		$criteria->compare('ControlId',$this->ControlId,true);
		$criteria->compare('ControlName',$this->ControlName,true);
		$criteria->compare('Prefix',$this->Prefix,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}