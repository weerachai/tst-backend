<?php

/**
 * This is the model class for table "GrpLevel1".
 *
 * The followings are the available columns in table 'GrpLevel1':
 * @property string $GrpLevel1Id
 * @property string $GrpLevel1Name
 * @property string $UpdateAt
 *
 * The followings are the available model relations:
 * @property Product[] $products
 */
class GrpLevel1 extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GrpLevel1 the static model class
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
		return 'GrpLevel1';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('GrpLevel1Name', 'required'),
			array('GrpLevel1Id, GrpLevel1Name', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('GrpLevel1Id, GrpLevel1Name, UpdateAt', 'safe', 'on'=>'search'),
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
			'products' => array(self::HAS_MANY, 'Product', 'GrpLevel1Id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'GrpLevel1Id' => 'Grp Level1',
			'GrpLevel1Name' => 'Grp Level1 Name',
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
		$criteria->compare('GrpLevel1Name',$this->GrpLevel1Name,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}