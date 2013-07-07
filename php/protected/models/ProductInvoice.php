<?php

/**
 * This is the model class for table "ProductInvoice".
 *
 * The followings are the available columns in table 'ProductInvoice':
 * @property string $InvoiceNo
 * @property string $OrderNo
 * @property string $SaleId
 * @property string $InvoiceDate
 * @property string $DueDate
 * @property string $Total
 * @property string $Paid
 * @property string $Status
 * @property string $UpdateAt
 *
 * The followings are the available model relations:
 * @property InvoiceDetail[] $invoiceDetails
 */
class ProductInvoice extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductInvoice the static model class
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
		return 'ProductInvoice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('InvoiceNo, OrderNo, SaleId, Status', 'length', 'max'=>255),
			array('Total, Paid', 'length', 'max'=>20),
			array('InvoiceDate, DueDate, UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('InvoiceNo, OrderNo, SaleId, InvoiceDate, DueDate, Total, Paid, Status, UpdateAt', 'safe', 'on'=>'search'),
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
			'invoiceDetails' => array(self::HAS_MANY, 'InvoiceDetail', 'InvoiceNo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'InvoiceNo' => 'Invoice No',
			'OrderNo' => 'Order No',
			'SaleId' => 'Sale',
			'InvoiceDate' => 'Invoice Date',
			'DueDate' => 'Due Date',
			'Total' => 'Total',
			'Paid' => 'Paid',
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

		$criteria->compare('InvoiceNo',$this->InvoiceNo,true);
		$criteria->compare('OrderNo',$this->OrderNo,true);
		$criteria->compare('SaleId',$this->SaleId,true);
		$criteria->compare('InvoiceDate',$this->InvoiceDate,true);
		$criteria->compare('DueDate',$this->DueDate,true);
		$criteria->compare('Total',$this->Total,true);
		$criteria->compare('Paid',$this->Paid,true);
		$criteria->compare('Status',$this->Status,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}