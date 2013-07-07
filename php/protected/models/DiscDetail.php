<?php

/**
 * This is the model class for table "DiscDetail".
 *
 * The followings are the available columns in table 'DiscDetail':
 * @property string $OrderNo
 * @property string $PromotionId
 * @property string $DiscBaht
 * @property integer $DiscPer1
 * @property integer $DiscPer2
 * @property integer $DiscPer3
 * @property string $DiscTotal
 * @property string $UpdateAt
 *
 * The followings are the available model relations:
 * @property ProductOrder $orderNo
 */
class DiscDetail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DiscDetail the static model class
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
		return 'DiscDetail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('DiscPer1, DiscPer2, DiscPer3', 'numerical', 'integerOnly'=>true),
			array('OrderNo, PromotionId', 'length', 'max'=>255),
			array('DiscBaht, DiscTotal', 'length', 'max'=>20),
			array('UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('OrderNo, PromotionId, DiscBaht, DiscPer1, DiscPer2, DiscPer3, DiscTotal, UpdateAt', 'safe', 'on'=>'search'),
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
			'orderNo' => array(self::BELONGS_TO, 'ProductOrder', 'OrderNo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'OrderNo' => 'Order No',
			'PromotionId' => 'Promotion',
			'DiscBaht' => 'Disc Baht',
			'DiscPer1' => 'Disc Per1',
			'DiscPer2' => 'Disc Per2',
			'DiscPer3' => 'Disc Per3',
			'DiscTotal' => 'Disc Total',
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

		$criteria->compare('OrderNo',$this->OrderNo,true);
		$criteria->compare('PromotionId',$this->PromotionId,true);
		$criteria->compare('DiscBaht',$this->DiscBaht,true);
		$criteria->compare('DiscPer1',$this->DiscPer1);
		$criteria->compare('DiscPer2',$this->DiscPer2);
		$criteria->compare('DiscPer3',$this->DiscPer3);
		$criteria->compare('DiscTotal',$this->DiscTotal,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}