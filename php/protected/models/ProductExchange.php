<?php

/**
 * This is the model class for table "ProductExchange".
 *
 * The followings are the available columns in table 'ProductExchange':
 * @property string $ExchangeNo
 * @property string $SaleId
 * @property string $CustomerId
 * @property string $ExchangeDate
 * @property string $InTotal
 * @property string $OutTotal
 * @property string $Status
 * @property string $UpdateAt
 *
 * The followings are the available model relations:
 * @property ExchangeInDetail[] $exchangeInDetails
 * @property ExchangeOutDetail[] $exchangeOutDetails
 */
class ProductExchange extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductExchange the static model class
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
		return 'ProductExchange';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ExchangeNo, SaleId, CustomerId, Status', 'length', 'max'=>255),
			array('InTotal, OutTotal', 'length', 'max'=>20),
			array('ExchangeDate, UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ExchangeNo, SaleId, CustomerId, ExchangeDate, InTotal, OutTotal, Status, UpdateAt', 'safe', 'on'=>'search'),
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
			'exchangeInDetails' => array(self::HAS_MANY, 'ExchangeInDetail', 'ExchangeNo'),
			'exchangeOutDetails' => array(self::HAS_MANY, 'ExchangeOutDetail', 'ExchangeNo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ExchangeNo' => 'Exchange No',
			'SaleId' => 'Sale',
			'CustomerId' => 'Customer',
			'ExchangeDate' => 'Exchange Date',
			'InTotal' => 'In Total',
			'OutTotal' => 'Out Total',
			'Status' => 'Status',
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

		$criteria->compare('ExchangeNo',$this->ExchangeNo,true);
		$criteria->compare('SaleId',$this->SaleId,true);
		$criteria->compare('CustomerId',$this->CustomerId,true);
		$criteria->compare('ExchangeDate',$this->ExchangeDate,true);
		$criteria->compare('InTotal',$this->InTotal,true);
		$criteria->compare('OutTotal',$this->OutTotal,true);
		$criteria->compare('Status',$this->Status,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}