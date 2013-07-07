<?php

/**
 * This is the model class for table "StockTransfer".
 *
 * The followings are the available columns in table 'StockTransfer':
 * @property string $TransferNo
 * @property string $SaleId
 * @property string $WarehouseId
 * @property string $WarehouseName
 * @property string $WarehouseType
 * @property string $TransferDate
 * @property string $Total
 * @property string $Status
 * @property string $UpdateAt
 *
 * The followings are the available model relations:
 * @property TransferDetail[] $transferDetails
 */
class StockTransfer extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StockTransfer the static model class
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
		return 'StockTransfer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('TransferNo, SaleId, WarehouseId, WarehouseName, WarehouseType, Status', 'length', 'max'=>255),
			array('Total', 'length', 'max'=>10),
			array('TransferDate, UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('TransferNo, SaleId, WarehouseId, WarehouseName, WarehouseType, TransferDate, Total, Status, UpdateAt', 'safe', 'on'=>'search'),
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
			'transferDetails' => array(self::HAS_MANY, 'TransferDetail', 'TransferNo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'TransferNo' => 'Transfer No',
			'SaleId' => 'Sale',
			'WarehouseId' => 'Warehouse',
			'WarehouseName' => 'Warehouse Name',
			'WarehouseType' => 'Warehouse Type',
			'TransferDate' => 'Transfer Date',
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

		$criteria->compare('TransferNo',$this->TransferNo,true);
		$criteria->compare('SaleId',$this->SaleId,true);
		$criteria->compare('WarehouseId',$this->WarehouseId,true);
		$criteria->compare('WarehouseName',$this->WarehouseName,true);
		$criteria->compare('WarehouseType',$this->WarehouseType,true);
		$criteria->compare('TransferDate',$this->TransferDate,true);
		$criteria->compare('Total',$this->Total,true);
		$criteria->compare('Status',$this->Status,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}