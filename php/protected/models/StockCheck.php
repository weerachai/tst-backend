<?php

/**
 * This is the model class for table "StockCheck".
 *
 * The followings are the available columns in table 'StockCheck':
 * @property string $SaleId
 * @property string $CheckDate
 * @property string $CustomerId
 * @property string $ProductId
 * @property integer $FrontQtyLevel1
 * @property integer $FrontQtyLevel2
 * @property integer $FrontQtyLevel3
 * @property integer $FrontQtyLevel4
 * @property integer $BackQtyLevel1
 * @property integer $BackQtyLevel2
 * @property integer $BackQtyLevel3
 * @property integer $BackQtyLevel4
 * @property integer $BuyQtyLevel1
 * @property integer $BuyQtyLevel2
 * @property integer $BuyQtyLevel3
 * @property integer $BuyQtyLevel4
 * @property string $UpdateAt
 *
 * The followings are the available model relations:
 * @property Product $product
 * @property Customer $customer
 * @property SaleUnit $sale
 */
class StockCheck extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StockCheck the static model class
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
		return 'StockCheck';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('FrontQtyLevel1, FrontQtyLevel2, FrontQtyLevel3, FrontQtyLevel4, BackQtyLevel1, BackQtyLevel2, BackQtyLevel3, BackQtyLevel4, BuyQtyLevel1, BuyQtyLevel2, BuyQtyLevel3, BuyQtyLevel4', 'numerical', 'integerOnly'=>true),
			array('SaleId, CustomerId, ProductId', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('SaleId, CheckDate, CustomerId, ProductId, FrontQtyLevel1, FrontQtyLevel2, FrontQtyLevel3, FrontQtyLevel4, BackQtyLevel1, BackQtyLevel2, BackQtyLevel3, BackQtyLevel4, BuyQtyLevel1, BuyQtyLevel2, BuyQtyLevel3, BuyQtyLevel4, UpdateAt', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'Product', 'ProductId'),
			'customer' => array(self::BELONGS_TO, 'Customer', 'CustomerId'),
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
			'CheckDate' => 'Check Date',
			'CustomerId' => 'Customer',
			'ProductId' => 'Product',
			'FrontQtyLevel1' => 'Front Qty Level1',
			'FrontQtyLevel2' => 'Front Qty Level2',
			'FrontQtyLevel3' => 'Front Qty Level3',
			'FrontQtyLevel4' => 'Front Qty Level4',
			'BackQtyLevel1' => 'Back Qty Level1',
			'BackQtyLevel2' => 'Back Qty Level2',
			'BackQtyLevel3' => 'Back Qty Level3',
			'BackQtyLevel4' => 'Back Qty Level4',
			'BuyQtyLevel1' => 'Buy Qty Level1',
			'BuyQtyLevel2' => 'Buy Qty Level2',
			'BuyQtyLevel3' => 'Buy Qty Level3',
			'BuyQtyLevel4' => 'Buy Qty Level4',
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
		$criteria->compare('CheckDate',$this->CheckDate,true);
		$criteria->compare('CustomerId',$this->CustomerId,true);
		$criteria->compare('ProductId',$this->ProductId,true);
		$criteria->compare('FrontQtyLevel1',$this->FrontQtyLevel1);
		$criteria->compare('FrontQtyLevel2',$this->FrontQtyLevel2);
		$criteria->compare('FrontQtyLevel3',$this->FrontQtyLevel3);
		$criteria->compare('FrontQtyLevel4',$this->FrontQtyLevel4);
		$criteria->compare('BackQtyLevel1',$this->BackQtyLevel1);
		$criteria->compare('BackQtyLevel2',$this->BackQtyLevel2);
		$criteria->compare('BackQtyLevel3',$this->BackQtyLevel3);
		$criteria->compare('BackQtyLevel4',$this->BackQtyLevel4);
		$criteria->compare('BuyQtyLevel1',$this->BuyQtyLevel1);
		$criteria->compare('BuyQtyLevel2',$this->BuyQtyLevel2);
		$criteria->compare('BuyQtyLevel3',$this->BuyQtyLevel3);
		$criteria->compare('BuyQtyLevel4',$this->BuyQtyLevel4);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}