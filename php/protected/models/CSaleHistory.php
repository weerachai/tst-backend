<?php

/**
 * This is the model class for table "cSaleHistory".
 *
 * The followings are the available columns in table 'cSaleHistory':
 * @property string $SaleId
 * @property string $CustomerId
 * @property string $ProductId
 * @property string $SaleAvg
 * @property string $M01
 * @property string $M02
 * @property string $M03
 * @property string $M04
 * @property string $M05
 * @property string $M06
 * @property string $M07
 * @property string $M08
 * @property string $M09
 * @property string $M10
 * @property string $M11
 * @property string $M12
 * @property string $UpdateAt
 *
 * The followings are the available model relations:
 * @property BSaleUnit $sale
 */
class CSaleHistory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CSaleHistory the static model class
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
		return 'cSaleHistory';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('SaleId, CustomerId, ProductId, SaleAvg, M01, M02, M03, M04, M05, M06, M07, M08, M09, M10, M11, M12', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('SaleId, CustomerId, ProductId, SaleAvg, M01, M02, M03, M04, M05, M06, M07, M08, M09, M10, M11, M12, UpdateAt', 'safe', 'on'=>'search'),
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
			'sale' => array(self::BELONGS_TO, 'BSaleUnit', 'SaleId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'SaleId' => 'Sale',
			'CustomerId' => 'Customer',
			'ProductId' => 'Product',
			'SaleAvg' => 'Sale Avg',
			'M01' => 'M01',
			'M02' => 'M02',
			'M03' => 'M03',
			'M04' => 'M04',
			'M05' => 'M05',
			'M06' => 'M06',
			'M07' => 'M07',
			'M08' => 'M08',
			'M09' => 'M09',
			'M10' => 'M10',
			'M11' => 'M11',
			'M12' => 'M12',
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
		$criteria->compare('CustomerId',$this->CustomerId,true);
		$criteria->compare('ProductId',$this->ProductId,true);
		$criteria->compare('SaleAvg',$this->SaleAvg,true);
		$criteria->compare('M01',$this->M01,true);
		$criteria->compare('M02',$this->M02,true);
		$criteria->compare('M03',$this->M03,true);
		$criteria->compare('M04',$this->M04,true);
		$criteria->compare('M05',$this->M05,true);
		$criteria->compare('M06',$this->M06,true);
		$criteria->compare('M07',$this->M07,true);
		$criteria->compare('M08',$this->M08,true);
		$criteria->compare('M09',$this->M09,true);
		$criteria->compare('M10',$this->M10,true);
		$criteria->compare('M11',$this->M11,true);
		$criteria->compare('M12',$this->M12,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}