<?php

/**
 * This is the model class for table "InvoicePayment".
 *
 * The followings are the available columns in table 'InvoicePayment':
 * @property string $PaymentId
 * @property string $InvoiceNo
 * @property string $Amount
 * @property string $UpdateAt
 */
class InvoicePayment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvoicePayment the static model class
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
		return 'InvoicePayment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('PaymentId, InvoiceNo', 'length', 'max'=>255),
			array('Amount', 'length', 'max'=>20),
			array('UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('PaymentId, InvoiceNo, Amount, UpdateAt', 'safe', 'on'=>'search'),
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
			'PaymentId' => 'Payment',
			'InvoiceNo' => 'Invoice No',
			'Amount' => 'Amount',
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

		$criteria->compare('PaymentId',$this->PaymentId,true);
		$criteria->compare('InvoiceNo',$this->InvoiceNo,true);
		$criteria->compare('Amount',$this->Amount,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}