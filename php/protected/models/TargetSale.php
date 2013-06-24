<?php

/**
 * This is the model class for table "TargetSale".
 *
 * The followings are the available columns in table 'TargetSale':
 * @property string $SaleId
 * @property string $Level
 * @property string $ProductOrGrpId
 * @property integer $TargetAmount
 * @property integer $TargetQty
 * @property string $TargetPack
 * @property string $UpdateAt
 */
class TargetSale extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TargetSale the static model class
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
		return 'TargetSale';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('TargetPack', 'required'),
			array('TargetAmount, TargetQty', 'numerical', 'integerOnly'=>true),
			array('SaleId, Level, ProductOrGrpId, TargetPack', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('SaleId, Level, ProductOrGrpId, TargetAmount, TargetQty, TargetPack, UpdateAt', 'safe', 'on'=>'search'),
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
			'Level' => 'Level',
			'ProductOrGrpId' => 'Product Or Grp',
			'TargetAmount' => 'Target Amount',
			'TargetQty' => 'Target Qty',
			'TargetPack' => 'Target Pack',
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
		$criteria->compare('Level',$this->Level,true);
		$criteria->compare('ProductOrGrpId',$this->ProductOrGrpId,true);
		$criteria->compare('TargetAmount',$this->TargetAmount);
		$criteria->compare('TargetQty',$this->TargetQty);
		$criteria->compare('TargetPack',$this->TargetPack,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}