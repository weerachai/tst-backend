<?php

/**
 * This is the model class for table "Payment".
 *
 * The followings are the available columns in table 'Payment':
 * @property string $CollectionNo
 * @property string $PaymentId
 * @property string $PaymentType
 * @property string $PaidAmount
 * @property string $DocNo
 * @property string $DocDate
 * @property string $Bank
 * @property string $Branch
 * @property string $AccountNo
 * @property string $UpdateAt
 *
 * The followings are the available model relations:
 * @property InvoicePayment[] $invoicePayments
 * @property BillCollection $collectionNo
 */
class Payment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Payment the static model class
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
		return 'Payment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('CollectionNo, PaymentId, PaymentType, DocNo, DocDate, Bank, Branch, AccountNo', 'length', 'max'=>255),
			array('PaidAmount', 'length', 'max'=>20),
			array('UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('CollectionNo, PaymentId, PaymentType, PaidAmount, DocNo, DocDate, Bank, Branch, AccountNo, UpdateAt', 'safe', 'on'=>'search'),
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
			'invoicePayments' => array(self::HAS_MANY, 'InvoicePayment', 'PaymentId'),
			'collectionNo' => array(self::BELONGS_TO, 'BillCollection', 'CollectionNo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'CollectionNo' => 'Collection No',
			'PaymentId' => 'Payment',
			'PaymentType' => 'Payment Type',
			'PaidAmount' => 'Paid Amount',
			'DocNo' => 'Doc No',
			'DocDate' => 'Doc Date',
			'Bank' => 'Bank',
			'Branch' => 'Branch',
			'AccountNo' => 'Account No',
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
		$criteria->compare('PaymentId',$this->PaymentId,true);
		$criteria->compare('PaymentType',$this->PaymentType,true);
		$criteria->compare('PaidAmount',$this->PaidAmount,true);
		$criteria->compare('DocNo',$this->DocNo,true);
		$criteria->compare('DocDate',$this->DocDate,true);
		$criteria->compare('Bank',$this->Bank,true);
		$criteria->compare('Branch',$this->Branch,true);
		$criteria->compare('AccountNo',$this->AccountNo,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}