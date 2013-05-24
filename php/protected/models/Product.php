<?php

/**
 * This is the model class for table "Product".
 *
 * The followings are the available columns in table 'Product':
 * @property string $GrpLevel1Id
 * @property string $GrpLevel2Id
 * @property string $GrpLevel3Id
 * @property string $ProductId
 * @property string $ProductName
 * @property string $PackLevel1
 * @property string $PackLevel2
 * @property string $PackLevel3
 * @property string $PackLevel4
 * @property string $PriceLevel1
 * @property string $PriceLevel2
 * @property string $PriceLevel3
 * @property string $PriceLevel4
 * @property integer $WeightLevel1
 * @property integer $WeightLevel2
 * @property integer $WeightLevel3
 * @property integer $WeightLevel4
 * @property string $FreeFlag
 * @property string $VatFlag
 * @property string $ShipFlag
 * @property string $MinShip
 * @property string $ShipFee
 * @property string $UpdateAt
 *
 * The followings are the available model relations:
 * @property FreeGrp[] $freeGrps
 * @property GrpLevel3 $grpLevel3
 * @property GrpLevel1 $grpLevel1
 * @property GrpLevel2 $grpLevel2
 * @property ProductGrp[] $productGrps
 */
class Product extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Product the static model class
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
		return 'Product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('GrpLevel1Id, ProductName', 'required'),
			array('WeightLevel1, WeightLevel2, WeightLevel3, WeightLevel4', 'numerical', 'integerOnly'=>true),
			array('GrpLevel1Id, GrpLevel2Id, GrpLevel3Id, ProductId, ProductName, PackLevel1, PackLevel2, PackLevel3, PackLevel4', 'length', 'max'=>255),
			array('PriceLevel1, PriceLevel2, PriceLevel3, PriceLevel4, MinShip, ShipFee', 'length', 'max'=>10),
			array('FreeFlag, VatFlag, ShipFlag', 'length', 'max'=>1),
			array('UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('GrpLevel1Id, GrpLevel2Id, GrpLevel3Id, ProductId, ProductName, PackLevel1, PackLevel2, PackLevel3, PackLevel4, PriceLevel1, PriceLevel2, PriceLevel3, PriceLevel4, WeightLevel1, WeightLevel2, WeightLevel3, WeightLevel4, FreeFlag, VatFlag, ShipFlag, MinShip, ShipFee, UpdateAt', 'safe', 'on'=>'search'),
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
			'freeGrps' => array(self::HAS_MANY, 'FreeGrp', 'ProductId'),
			'grpLevel3' => array(self::BELONGS_TO, 'GrpLevel3', 'GrpLevel3Id'),
			'grpLevel1' => array(self::BELONGS_TO, 'GrpLevel1', 'GrpLevel1Id'),
			'grpLevel2' => array(self::BELONGS_TO, 'GrpLevel2', 'GrpLevel2Id'),
			'productGrps' => array(self::HAS_MANY, 'ProductGrp', 'ProductId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'GrpLevel1Id' => 'Grp Level1',
			'GrpLevel2Id' => 'Grp Level2',
			'GrpLevel3Id' => 'Grp Level3',
			'ProductId' => 'Product',
			'ProductName' => 'Product Name',
			'PackLevel1' => 'Pack Level1',
			'PackLevel2' => 'Pack Level2',
			'PackLevel3' => 'Pack Level3',
			'PackLevel4' => 'Pack Level4',
			'PriceLevel1' => 'Price Level1',
			'PriceLevel2' => 'Price Level2',
			'PriceLevel3' => 'Price Level3',
			'PriceLevel4' => 'Price Level4',
			'WeightLevel1' => 'Weight Level1',
			'WeightLevel2' => 'Weight Level2',
			'WeightLevel3' => 'Weight Level3',
			'WeightLevel4' => 'Weight Level4',
			'FreeFlag' => 'Free Flag',
			'VatFlag' => 'Vat Flag',
			'ShipFlag' => 'Ship Flag',
			'MinShip' => 'Min Ship',
			'ShipFee' => 'Ship Fee',
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

		$criteria->compare('GrpLevel1Id',$this->GrpLevel1Id,true);
		$criteria->compare('GrpLevel2Id',$this->GrpLevel2Id,true);
		$criteria->compare('GrpLevel3Id',$this->GrpLevel3Id,true);
		$criteria->compare('ProductId',$this->ProductId,true);
		$criteria->compare('ProductName',$this->ProductName,true);
		$criteria->compare('PackLevel1',$this->PackLevel1,true);
		$criteria->compare('PackLevel2',$this->PackLevel2,true);
		$criteria->compare('PackLevel3',$this->PackLevel3,true);
		$criteria->compare('PackLevel4',$this->PackLevel4,true);
		$criteria->compare('PriceLevel1',$this->PriceLevel1,true);
		$criteria->compare('PriceLevel2',$this->PriceLevel2,true);
		$criteria->compare('PriceLevel3',$this->PriceLevel3,true);
		$criteria->compare('PriceLevel4',$this->PriceLevel4,true);
		$criteria->compare('WeightLevel1',$this->WeightLevel1);
		$criteria->compare('WeightLevel2',$this->WeightLevel2);
		$criteria->compare('WeightLevel3',$this->WeightLevel3);
		$criteria->compare('WeightLevel4',$this->WeightLevel4);
		$criteria->compare('FreeFlag',$this->FreeFlag,true);
		$criteria->compare('VatFlag',$this->VatFlag,true);
		$criteria->compare('ShipFlag',$this->ShipFlag,true);
		$criteria->compare('MinShip',$this->MinShip,true);
		$criteria->compare('ShipFee',$this->ShipFee,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}