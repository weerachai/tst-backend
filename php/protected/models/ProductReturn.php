<?php

/**
 * This is the model class for table "ProductReturn".
 *
 * The followings are the available columns in table 'ProductReturn':
 * @property string $ReturnNo
 * @property string $SaleId
 * @property string $CustomerId
 * @property string $ReturnDate
 * @property string $Total
 * @property string $Vat
 * @property string $Status
 * @property string $UpdateAt
 *
 * The followings are the available model relations:
 * @property Customer $customer
 * @property SaleUnit $sale
 * @property Product[] $products
 */
class ProductReturn extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductReturn the static model class
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
		return 'ProductReturn';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ReturnNo, SaleId, CustomerId, Status', 'length', 'max'=>255),
			array('Total, Vat', 'length', 'max'=>20),
			array('ReturnDate, UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ReturnNo, SaleId, CustomerId, ReturnDate, Total, Vat, Status, UpdateAt', 'safe', 'on'=>'search'),
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
			'customer' => array(self::BELONGS_TO, 'Customer', 'CustomerId'),
			'sale' => array(self::BELONGS_TO, 'SaleUnit', 'SaleId'),
			'products' => array(self::MANY_MANY, 'Product', 'ReturnDetail(ReturnNo, ProductId)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ReturnNo' => 'Return No',
			'SaleId' => 'Sale',
			'CustomerId' => 'Customer',
			'ReturnDate' => 'Return Date',
			'Total' => 'Total',
			'Vat' => 'Vat',
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

		$criteria->compare('ReturnNo',$this->ReturnNo,true);
		$criteria->compare('SaleId',$this->SaleId,true);
		$criteria->compare('CustomerId',$this->CustomerId,true);
		$criteria->compare('ReturnDate',$this->ReturnDate,true);
		$criteria->compare('Total',$this->Total,true);
		$criteria->compare('Vat',$this->Vat,true);
		$criteria->compare('Status',$this->Status,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}