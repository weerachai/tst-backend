<?php

/**
 * This is the model class for table "GrpLevel2".
 *
 * The followings are the available columns in table 'GrpLevel2':
 * @property string $GrpLevel1Id
 * @property string $GrpLevel2Id
 * @property string $GrpLevel2Name
 * @property string $UpdateAt
 */
class GrpLevel2 extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GrpLevel2 the static model class
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
		return 'GrpLevel2';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('GrpLevel1Id, GrpLevel2Name', 'required'),
			array('GrpLevel1Id, GrpLevel2Id, GrpLevel2Name', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('GrpLevel1Id, GrpLevel2Id, GrpLevel2Name, UpdateAt', 'safe', 'on'=>'search'),
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
			'GrpLevel1Id' => 'Grp Level1',
			'GrpLevel2Id' => 'Grp Level2',
			'GrpLevel2Name' => 'Grp Level2 Name',
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

		$criteria->compare('GrpLevel1Id',$this->GrpLevel1Id,true);
		$criteria->compare('GrpLevel2Id',$this->GrpLevel2Id,true);
		$criteria->compare('GrpLevel2Name',$this->GrpLevel2Name,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}