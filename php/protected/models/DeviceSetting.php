<?php

/**
 * This is the model class for table "DeviceSetting".
 *
 * The followings are the available columns in table 'DeviceSetting':
 * @property string $SaleId
 * @property string $SaleType
 * @property string $PromotionSku
 * @property string $PromotionGroup
 * @property string $PromotionBill
 * @property string $PromotionAccu
 * @property string $Vat
 * @property string $OverStock
 * @property integer $DayToClear
 * @property string $UpdateAt
 *
 * The followings are the available model relations:
 * @property SaleUnit $sale
 */
class DeviceSetting extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DeviceSetting the static model class
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
		return 'DeviceSetting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('DayToClear', 'numerical', 'integerOnly'=>true),
			array('SaleId, SaleType, PromotionSku, PromotionGroup, PromotionBill, PromotionAccu, Vat', 'length', 'max'=>255),
			array('OverStock', 'length', 'max'=>1),
			array('UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('SaleId, SaleType, PromotionSku, PromotionGroup, PromotionBill, PromotionAccu, Vat, OverStock, DayToClear, UpdateAt', 'safe', 'on'=>'search'),
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
			'SaleId' => 'Sale',
			'SaleType' => 'Sale Type',
			'PromotionSku' => 'Promotion Sku',
			'PromotionGroup' => 'Promotion Group',
			'PromotionBill' => 'Promotion Bill',
			'PromotionAccu' => 'Promotion Accu',
			'Vat' => 'Vat',
			'OverStock' => 'Over Stock',
			'DayToClear' => 'Day To Clear',
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
		$criteria->compare('SaleType',$this->SaleType,true);
		$criteria->compare('PromotionSku',$this->PromotionSku,true);
		$criteria->compare('PromotionGroup',$this->PromotionGroup,true);
		$criteria->compare('PromotionBill',$this->PromotionBill,true);
		$criteria->compare('PromotionAccu',$this->PromotionAccu,true);
		$criteria->compare('Vat',$this->Vat,true);
		$criteria->compare('OverStock',$this->OverStock,true);
		$criteria->compare('DayToClear',$this->DayToClear);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}