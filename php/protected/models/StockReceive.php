<?php

/**
 * This is the model class for table "StockReceive".
 *
 * The followings are the available columns in table 'StockReceive':
 * @property string $RequestNo
 * @property string $DeliverNo
 * @property string $ReceiveNo
 * @property string $SaleId
 * @property string $ReceiveDate
 * @property string $Total
 * @property string $Status
 * @property string $UpdateAt
 *
 * The followings are the available model relations:
 * @property ReceiveDetail[] $receiveDetails
 */
class StockReceive extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StockReceive the static model class
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
		return 'StockReceive';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('RequestNo, DeliverNo, ReceiveNo, SaleId, Status', 'length', 'max'=>255),
			array('Total', 'length', 'max'=>10),
			array('ReceiveDate, UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('RequestNo, DeliverNo, ReceiveNo, SaleId, ReceiveDate, Total, Status, UpdateAt', 'safe', 'on'=>'search'),
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
			'receiveDetails' => array(self::HAS_MANY, 'ReceiveDetail', 'ReceiveNo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'RequestNo' => 'Request No',
			'DeliverNo' => 'Deliver No',
			'ReceiveNo' => 'Receive No',
			'SaleId' => 'Sale',
			'ReceiveDate' => 'Receive Date',
			'Total' => 'Total',
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

		$criteria->compare('RequestNo',$this->RequestNo,true);
		$criteria->compare('DeliverNo',$this->DeliverNo,true);
		$criteria->compare('ReceiveNo',$this->ReceiveNo,true);
		$criteria->compare('SaleId',$this->SaleId,true);
		$criteria->compare('ReceiveDate',$this->ReceiveDate,true);
		$criteria->compare('Total',$this->Total,true);
		$criteria->compare('Status',$this->Status,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}