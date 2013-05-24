<?php

/**
 * This is the model class for table "Promotion".
 *
 * The followings are the available columns in table 'Promotion':
 * @property string $PromotionGroup
 * @property string $PromotionId
 * @property string $StartDate
 * @property string $EndDate
 * @property string $PromotionType
 * @property string $ProductOrGrpId
 * @property integer $MinAmount
 * @property integer $MinSku
 * @property integer $MinQty
 * @property string $Pack
 * @property integer $DiscBaht
 * @property integer $DiscPerAmount
 * @property integer $DiscPerQty
 * @property integer $DiscPer1
 * @property integer $DiscPer2
 * @property integer $DiscPer3
 * @property string $FreeType
 * @property string $FreeProductOrGrpId
 * @property integer $FreeQty
 * @property string $FreePack
 * @property integer $FreePerAmount
 * @property integer $FreePerQty
 * @property integer $FreeBaht
 * @property string $Formula
 * @property string $UpdateAt
 */
class Promotion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Promotion the static model class
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
		return 'Promotion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('MinAmount, MinSku, MinQty, DiscBaht, DiscPerAmount, DiscPerQty, DiscPer1, DiscPer2, DiscPer3, FreeQty, FreePerAmount, FreePerQty, FreeBaht', 'numerical', 'integerOnly'=>true),
			array('PromotionGroup, PromotionId, PromotionType, ProductOrGrpId, Pack, FreeType, FreeProductOrGrpId, FreePack, Formula', 'length', 'max'=>255),
			array('StartDate, EndDate, UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('PromotionGroup, PromotionId, StartDate, EndDate, PromotionType, ProductOrGrpId, MinAmount, MinSku, MinQty, Pack, DiscBaht, DiscPerAmount, DiscPerQty, DiscPer1, DiscPer2, DiscPer3, FreeType, FreeProductOrGrpId, FreeQty, FreePack, FreePerAmount, FreePerQty, FreeBaht, Formula, UpdateAt', 'safe', 'on'=>'search'),
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
			'PromotionGroup' => 'Promotion Group',
			'PromotionId' => 'Promotion',
			'StartDate' => 'Start Date',
			'EndDate' => 'End Date',
			'PromotionType' => 'Promotion Type',
			'ProductOrGrpId' => 'Product Or Grp',
			'MinAmount' => 'Min Amount',
			'MinSku' => 'Min Sku',
			'MinQty' => 'Min Qty',
			'Pack' => 'Pack',
			'DiscBaht' => 'Disc Baht',
			'DiscPerAmount' => 'Disc Per Amount',
			'DiscPerQty' => 'Disc Per Qty',
			'DiscPer1' => 'Disc Per1',
			'DiscPer2' => 'Disc Per2',
			'DiscPer3' => 'Disc Per3',
			'FreeType' => 'Free Type',
			'FreeProductOrGrpId' => 'Free Product Or Grp',
			'FreeQty' => 'Free Qty',
			'FreePack' => 'Free Pack',
			'FreePerAmount' => 'Free Per Amount',
			'FreePerQty' => 'Free Per Qty',
			'FreeBaht' => 'Free Baht',
			'Formula' => 'Formula',
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

		$criteria->compare('PromotionGroup',$this->PromotionGroup,true);
		$criteria->compare('PromotionId',$this->PromotionId,true);
		$criteria->compare('StartDate',$this->StartDate,true);
		$criteria->compare('EndDate',$this->EndDate,true);
		$criteria->compare('PromotionType',$this->PromotionType,true);
		$criteria->compare('ProductOrGrpId',$this->ProductOrGrpId,true);
		$criteria->compare('MinAmount',$this->MinAmount);
		$criteria->compare('MinSku',$this->MinSku);
		$criteria->compare('MinQty',$this->MinQty);
		$criteria->compare('Pack',$this->Pack,true);
		$criteria->compare('DiscBaht',$this->DiscBaht);
		$criteria->compare('DiscPerAmount',$this->DiscPerAmount);
		$criteria->compare('DiscPerQty',$this->DiscPerQty);
		$criteria->compare('DiscPer1',$this->DiscPer1);
		$criteria->compare('DiscPer2',$this->DiscPer2);
		$criteria->compare('DiscPer3',$this->DiscPer3);
		$criteria->compare('FreeType',$this->FreeType,true);
		$criteria->compare('FreeProductOrGrpId',$this->FreeProductOrGrpId,true);
		$criteria->compare('FreeQty',$this->FreeQty);
		$criteria->compare('FreePack',$this->FreePack,true);
		$criteria->compare('FreePerAmount',$this->FreePerAmount);
		$criteria->compare('FreePerQty',$this->FreePerQty);
		$criteria->compare('FreeBaht',$this->FreeBaht);
		$criteria->compare('Formula',$this->Formula,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}