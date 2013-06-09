<?php

/**
 * This is the model class for table "ReturnDetail".
 *
 * The followings are the available columns in table 'ReturnDetail':
 * @property string $ReturnNo
 * @property string $ProductId
 * @property string $MfgDate
 * @property string $ExpDate
 * @property string $LotNo
 * @property string $OrderNo
 * @property string $Reason
 * @property string $Condition
 * @property integer $QtyLevel1
 * @property integer $QtyLevel2
 * @property integer $QtyLevel3
 * @property integer $QtyLevel4
 * @property string $PriceLevel1
 * @property string $PriceLevel2
 * @property string $PriceLevel3
 * @property string $PriceLevel4
 * @property string $UpdateAt
 */
class ReturnDetail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReturnDetail the static model class
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
		return 'ReturnDetail';
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
			array('ReturnNo, ProductId, LotNo, OrderNo, Reason, Condition', 'length', 'max'=>255),
			array('PriceLevel1, PriceLevel2, PriceLevel3, PriceLevel4', 'length', 'max'=>10),
			array('MfgDate, ExpDate, UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ReturnNo, ProductId, MfgDate, ExpDate, LotNo, OrderNo, Reason, Condition, QtyLevel1, QtyLevel2, QtyLevel3, QtyLevel4, PriceLevel1, PriceLevel2, PriceLevel3, PriceLevel4, UpdateAt', 'safe', 'on'=>'search'),
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
			'ReturnNo' => 'Return No',
			'ProductId' => 'Product',
			'MfgDate' => 'Mfg Date',
			'ExpDate' => 'Exp Date',
			'LotNo' => 'Lot No',
			'OrderNo' => 'Order No',
			'Reason' => 'Reason',
			'Condition' => 'Condition',
			'QtyLevel1' => 'Qty Level1',
			'QtyLevel2' => 'Qty Level2',
			'QtyLevel3' => 'Qty Level3',
			'QtyLevel4' => 'Qty Level4',
			'PriceLevel1' => 'Price Level1',
			'PriceLevel2' => 'Price Level2',
			'PriceLevel3' => 'Price Level3',
			'PriceLevel4' => 'Price Level4',
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
		$criteria->compare('ProductId',$this->ProductId,true);
		$criteria->compare('MfgDate',$this->MfgDate,true);
		$criteria->compare('ExpDate',$this->ExpDate,true);
		$criteria->compare('LotNo',$this->LotNo,true);
		$criteria->compare('OrderNo',$this->OrderNo,true);
		$criteria->compare('Reason',$this->Reason,true);
		$criteria->compare('Condition',$this->Condition,true);
		$criteria->compare('QtyLevel1',$this->QtyLevel1);
		$criteria->compare('QtyLevel2',$this->QtyLevel2);
		$criteria->compare('QtyLevel3',$this->QtyLevel3);
		$criteria->compare('QtyLevel4',$this->QtyLevel4);
		$criteria->compare('PriceLevel1',$this->PriceLevel1,true);
		$criteria->compare('PriceLevel2',$this->PriceLevel2,true);
		$criteria->compare('PriceLevel3',$this->PriceLevel3,true);
		$criteria->compare('PriceLevel4',$this->PriceLevel4,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}