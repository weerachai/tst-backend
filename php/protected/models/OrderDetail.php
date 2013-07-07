<?php

/**
 * This is the model class for table "OrderDetail".
 *
 * The followings are the available columns in table 'OrderDetail':
 * @property string $OrderNo
 * @property string $ProductId
 * @property integer $BuyLevel1
 * @property integer $BuyLevel2
 * @property integer $BuyLevel3
 * @property integer $BuyLevel4
 * @property string $PriceLevel1
 * @property string $PriceLevel2
 * @property string $PriceLevel3
 * @property string $PriceLevel4
 * @property string $PromotionAccuId
 * @property string $PromotionAccuType
 * @property string $OrderNoUsed
 * @property string $UpdateAt
 *
 * The followings are the available model relations:
 * @property ProductOrder $orderNo
 */
class OrderDetail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderDetail the static model class
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
		return 'OrderDetail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('BuyLevel1, BuyLevel2, BuyLevel3, BuyLevel4', 'numerical', 'integerOnly'=>true),
			array('OrderNo, ProductId, PromotionAccuId, PromotionAccuType, OrderNoUsed', 'length', 'max'=>255),
			array('PriceLevel1, PriceLevel2, PriceLevel3, PriceLevel4', 'length', 'max'=>10),
			array('UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('OrderNo, ProductId, BuyLevel1, BuyLevel2, BuyLevel3, BuyLevel4, PriceLevel1, PriceLevel2, PriceLevel3, PriceLevel4, PromotionAccuId, PromotionAccuType, OrderNoUsed, UpdateAt', 'safe', 'on'=>'search'),
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
			'orderNo' => array(self::BELONGS_TO, 'ProductOrder', 'OrderNo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'OrderNo' => 'Order No',
			'ProductId' => 'Product',
			'BuyLevel1' => 'Buy Level1',
			'BuyLevel2' => 'Buy Level2',
			'BuyLevel3' => 'Buy Level3',
			'BuyLevel4' => 'Buy Level4',
			'PriceLevel1' => 'Price Level1',
			'PriceLevel2' => 'Price Level2',
			'PriceLevel3' => 'Price Level3',
			'PriceLevel4' => 'Price Level4',
			'PromotionAccuId' => 'Promotion Accu',
			'PromotionAccuType' => 'Promotion Accu Type',
			'OrderNoUsed' => 'Order No Used',
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

		$criteria->compare('OrderNo',$this->OrderNo,true);
		$criteria->compare('ProductId',$this->ProductId,true);
		$criteria->compare('BuyLevel1',$this->BuyLevel1);
		$criteria->compare('BuyLevel2',$this->BuyLevel2);
		$criteria->compare('BuyLevel3',$this->BuyLevel3);
		$criteria->compare('BuyLevel4',$this->BuyLevel4);
		$criteria->compare('PriceLevel1',$this->PriceLevel1,true);
		$criteria->compare('PriceLevel2',$this->PriceLevel2,true);
		$criteria->compare('PriceLevel3',$this->PriceLevel3,true);
		$criteria->compare('PriceLevel4',$this->PriceLevel4,true);
		$criteria->compare('PromotionAccuId',$this->PromotionAccuId,true);
		$criteria->compare('PromotionAccuType',$this->PromotionAccuType,true);
		$criteria->compare('OrderNoUsed',$this->OrderNoUsed,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}