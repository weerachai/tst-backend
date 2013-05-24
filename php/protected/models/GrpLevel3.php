<?php

/**
 * This is the model class for table "GrpLevel3".
 *
 * The followings are the available columns in table 'GrpLevel3':
 * @property string $GrpLevel2Id
 * @property string $GrpLevel3Id
 * @property string $GrpLevel3Name
 * @property string $UpdateAt
 *
 * The followings are the available model relations:
 * @property Product[] $products
 */
class GrpLevel3 extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GrpLevel3 the static model class
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
		return 'GrpLevel3';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('GrpLevel2Id, GrpLevel3Name', 'required'),
			array('GrpLevel2Id, GrpLevel3Id, GrpLevel3Name', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('GrpLevel2Id, GrpLevel3Id, GrpLevel3Name, UpdateAt', 'safe', 'on'=>'search'),
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
			'products' => array(self::HAS_MANY, 'Product', 'GrpLevel3Id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'GrpLevel2Id' => 'Grp Level2',
			'GrpLevel3Id' => 'Grp Level3',
			'GrpLevel3Name' => 'Grp Level3 Name',
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

		$criteria->compare('GrpLevel2Id',$this->GrpLevel2Id,true);
		$criteria->compare('GrpLevel3Id',$this->GrpLevel3Id,true);
		$criteria->compare('GrpLevel3Name',$this->GrpLevel3Name,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}