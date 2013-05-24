<?php

/**
 * This is the model class for table "StockCheckList".
 *
 * The followings are the available columns in table 'StockCheckList':
 * @property string $SaleId
 * @property string $GrpLevel1Id
 * @property string $GrpLevel2Id
 * @property string $GrpLevel3Id
 * @property string $ProductId
 * @property string $UpdateAt
 *
 * The followings are the available model relations:
 * @property Product $product
 * @property GrpLevel1 $grpLevel1
 * @property GrpLevel2 $grpLevel2
 * @property GrpLevel3 $grpLevel3
 * @property SaleUnit $sale
 */
class StockCheckList extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StockCheckList the static model class
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
		return 'StockCheckList';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('SaleId, GrpLevel1Id, GrpLevel2Id, GrpLevel3Id, ProductId', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('SaleId, GrpLevel1Id, GrpLevel2Id, GrpLevel3Id, ProductId, UpdateAt', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'Product', 'ProductId'),
			'grpLevel1' => array(self::BELONGS_TO, 'GrpLevel1', 'GrpLevel1Id'),
			'grpLevel2' => array(self::BELONGS_TO, 'GrpLevel2', 'GrpLevel2Id'),
			'grpLevel3' => array(self::BELONGS_TO, 'GrpLevel3', 'GrpLevel3Id'),
			'sale' => array(self::BELONGS_TO, 'SaleUnit', 'SaleId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'SaleId' => 'Sale',
			'GrpLevel1Id' => 'Grp Level1',
			'GrpLevel2Id' => 'Grp Level2',
			'GrpLevel3Id' => 'Grp Level3',
			'ProductId' => 'Product',
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
		$criteria->compare('GrpLevel1Id',$this->GrpLevel1Id,true);
		$criteria->compare('GrpLevel2Id',$this->GrpLevel2Id,true);
		$criteria->compare('GrpLevel3Id',$this->GrpLevel3Id,true);
		$criteria->compare('ProductId',$this->ProductId,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}