<?php

/**
 * This is the model class for table "BillCollection".
 *
 * The followings are the available columns in table 'BillCollection':
 * @property string $CollectionNo
 * @property string $SaleId
 * @property string $CustomerId
 * @property string $CollectionDate
 * @property string $CollectionAmount
 * @property string $PaidAmount
 * @property string $Status
 * @property string $UpdateAt
 *
 * The followings are the available model relations:
 * @property Payment[] $payments
 */
class BillCollection extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BillCollection the static model class
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
		return 'BillCollection';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('CollectionNo, SaleId, CustomerId, Status', 'length', 'max'=>255),
			array('CollectionAmount, PaidAmount', 'length', 'max'=>20),
			array('CollectionDate, UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('CollectionNo, SaleId, CustomerId, CollectionDate, CollectionAmount, PaidAmount, Status, UpdateAt', 'safe', 'on'=>'search'),
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
			'payments' => array(self::HAS_MANY, 'Payment', 'CollectionNo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'CollectionNo' => 'Collection No',
			'SaleId' => 'Sale',
			'CustomerId' => 'Customer',
			'CollectionDate' => 'Collection Date',
			'CollectionAmount' => 'Collection Amount',
			'PaidAmount' => 'Paid Amount',
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

		$criteria->compare('CollectionNo',$this->CollectionNo,true);
		$criteria->compare('SaleId',$this->SaleId,true);
		$criteria->compare('CustomerId',$this->CustomerId,true);
		$criteria->compare('CollectionDate',$this->CollectionDate,true);
		$criteria->compare('CollectionAmount',$this->CollectionAmount,true);
		$criteria->compare('PaidAmount',$this->PaidAmount,true);
		$criteria->compare('Status',$this->Status,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}