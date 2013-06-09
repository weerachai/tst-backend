<?php

/**
 * This is the model class for table "InvoiceDetail".
 *
 * The followings are the available columns in table 'InvoiceDetail':
 * @property string $InvoiceNo
 * @property string $ProductId
 * @property integer $QtyLevel1
 * @property integer $QtyLevel2
 * @property integer $QtyLevel3
 * @property integer $QtyLevel4
 * @property string $Status
 * @property string $UpdateAt
 */
class InvoiceDetail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvoiceDetail the static model class
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
		return 'InvoiceDetail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('QtyLevel1, QtyLevel2, QtyLevel3, QtyLevel4', 'numerical', 'integerOnly'=>true),
			array('InvoiceNo, ProductId, Status', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('InvoiceNo, ProductId, QtyLevel1, QtyLevel2, QtyLevel3, QtyLevel4, Status, UpdateAt', 'safe', 'on'=>'search'),
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
			'InvoiceNo' => 'Invoice No',
			'ProductId' => 'Product',
			'QtyLevel1' => 'Qty Level1',
			'QtyLevel2' => 'Qty Level2',
			'QtyLevel3' => 'Qty Level3',
			'QtyLevel4' => 'Qty Level4',
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
		$criteria->compare('ProductId',$this->ProductId,true);
		$criteria->compare('QtyLevel1',$this->QtyLevel1);
		$criteria->compare('QtyLevel2',$this->QtyLevel2);
		$criteria->compare('QtyLevel3',$this->QtyLevel3);
		$criteria->compare('QtyLevel4',$this->QtyLevel4);
		$criteria->compare('Status',$this->Status,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}