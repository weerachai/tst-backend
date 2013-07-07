<?php

/**
 * This is the model class for table "MoneyTransfer".
 *
 * The followings are the available columns in table 'MoneyTransfer':
 * @property string $SaleId
 * @property string $TransferDate
 * @property string $StartDate
 * @property string $EndDate
 * @property string $Amount
 * @property string $Bank
 * @property string $Branch
 * @property string $AccountNo
 * @property string $Status
 * @property string $UpdateAt
 */
class MoneyTransfer extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MoneyTransfer the static model class
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
		return 'MoneyTransfer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('SaleId, Bank, Branch, AccountNo, Status', 'length', 'max'=>255),
			array('Amount', 'length', 'max'=>20),
			array('TransferDate, StartDate, UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('SaleId, TransferDate, StartDate, EndDate, Amount, Bank, Branch, AccountNo, Status, UpdateAt', 'safe', 'on'=>'search'),
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
			'TransferDate' => 'Transfer Date',
			'StartDate' => 'Start Date',
			'EndDate' => 'End Date',
			'Amount' => 'Amount',
			'Bank' => 'Bank',
			'Branch' => 'Branch',
			'AccountNo' => 'Account No',
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

		$criteria->compare('SaleId',$this->SaleId,true);
		$criteria->compare('TransferDate',$this->TransferDate,true);
		$criteria->compare('StartDate',$this->StartDate,true);
		$criteria->compare('EndDate',$this->EndDate,true);
		$criteria->compare('Amount',$this->Amount,true);
		$criteria->compare('Bank',$this->Bank,true);
		$criteria->compare('Branch',$this->Branch,true);
		$criteria->compare('AccountNo',$this->AccountNo,true);
		$criteria->compare('Status',$this->Status,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}