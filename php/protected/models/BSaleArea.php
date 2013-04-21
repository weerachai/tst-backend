<?php

/**
 * This is the model class for table "bSaleArea".
 *
 * The followings are the available columns in table 'bSaleArea':
 * @property string $AreaId
 * @property string $AreaName
 * @property string $Province
 * @property string $District
 * @property string $SubDistrict
 * @property string $SupervisorId
 *
 * The followings are the available model relations:
 * @property BEmployee $supervisor
 */
class BSaleArea extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BSaleArea the static model class
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
		return 'bSaleArea';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('AreaName', 'required'),
			array('AreaId, AreaName, Province, District, SubDistrict, SupervisorId', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('AreaId, AreaName, Province, District, SubDistrict, SupervisorId', 'safe', 'on'=>'search'),
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
			'supervisor' => array(self::BELONGS_TO, 'BEmployee', 'SupervisorId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'AreaId' => 'Area',
			'AreaName' => 'Area Name',
			'Province' => 'Province',
			'District' => 'District',
			'SubDistrict' => 'Sub District',
			'SupervisorId' => 'Supervisor',
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

		$criteria->compare('AreaId',$this->AreaId,true);
		$criteria->compare('AreaName',$this->AreaName,true);
		$criteria->compare('Province',$this->Province,true);
		$criteria->compare('District',$this->District,true);
		$criteria->compare('SubDistrict',$this->SubDistrict,true);
		$criteria->compare('SupervisorId',$this->SupervisorId,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}