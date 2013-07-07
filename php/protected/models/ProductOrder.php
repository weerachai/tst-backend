<?php

/**
 * This is the model class for table "ProductOrder".
 *
 * The followings are the available columns in table 'ProductOrder':
 * @property string $OrderNo
 * @property string $OrderType
 * @property string $SaleId
 * @property string $CustomerId
 * @property string $OrderDate
 * @property string $Total
 * @property string $Vat
 * @property string $Discount
 * @property string $Shipping
 * @property string $DeliverDate
 * @property string $DeliverAddress
 * @property string $PaymentType
 * @property string $Status
 * @property string $Remark
 * @property string $UpdateAt
 *
 * The followings are the available model relations:
 * @property DiscDetail[] $discDetails
 * @property FreeDetail[] $freeDetails
 * @property OrderDetail[] $orderDetails
 */
class ProductOrder extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductOrder the static model class
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
		return 'ProductOrder';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('OrderNo, OrderType, SaleId, CustomerId, PaymentType, Status, Remark', 'length', 'max'=>255),
			array('Total, Vat, Discount, Shipping', 'length', 'max'=>20),
			array('OrderDate, DeliverDate, DeliverAddress, UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('OrderNo, OrderType, SaleId, CustomerId, OrderDate, Total, Vat, Discount, Shipping, DeliverDate, DeliverAddress, PaymentType, Status, Remark, UpdateAt', 'safe', 'on'=>'search'),
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
			'discDetails' => array(self::HAS_MANY, 'DiscDetail', 'OrderNo'),
			'freeDetails' => array(self::HAS_MANY, 'FreeDetail', 'OrderNo'),
			'orderDetails' => array(self::HAS_MANY, 'OrderDetail', 'OrderNo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'OrderNo' => 'Order No',
			'OrderType' => 'Order Type',
			'SaleId' => 'Sale',
			'CustomerId' => 'Customer',
			'OrderDate' => 'Order Date',
			'Total' => 'Total',
			'Vat' => 'Vat',
			'Discount' => 'Discount',
			'Shipping' => 'Shipping',
			'DeliverDate' => 'Deliver Date',
			'DeliverAddress' => 'Deliver Address',
			'PaymentType' => 'Payment Type',
			'Status' => 'Status',
			'Remark' => 'Remark',
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
		$criteria->compare('OrderType',$this->OrderType,true);
		$criteria->compare('SaleId',$this->SaleId,true);
		$criteria->compare('CustomerId',$this->CustomerId,true);
		$criteria->compare('OrderDate',$this->OrderDate,true);
		$criteria->compare('Total',$this->Total,true);
		$criteria->compare('Vat',$this->Vat,true);
		$criteria->compare('Discount',$this->Discount,true);
		$criteria->compare('Shipping',$this->Shipping,true);
		$criteria->compare('DeliverDate',$this->DeliverDate,true);
		$criteria->compare('DeliverAddress',$this->DeliverAddress,true);
		$criteria->compare('PaymentType',$this->PaymentType,true);
		$criteria->compare('Status',$this->Status,true);
		$criteria->compare('Remark',$this->Remark,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}