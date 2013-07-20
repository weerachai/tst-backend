<?php

/**
 * This is the model class for table "Stock".
 *
 * The followings are the available columns in table 'Stock':
 * @property string $SaleId
 * @property string $ProductId
 * @property integer $StartQtyLevel1
 * @property integer $StartQtyLevel2
 * @property integer $StartQtyLevel3
 * @property integer $StartQtyLevel4
 * @property integer $CurrentQtyLevel1
 * @property integer $CurrentQtyLevel2
 * @property integer $CurrentQtyLevel3
 * @property integer $CurrentQtyLevel4
 * @property integer $BadQtyLevel1
 * @property integer $BadQtyLevel2
 * @property integer $BadQtyLevel3
 * @property integer $BadQtyLevel4
 * @property integer $MidInQtyLevel1
 * @property integer $MidInQtyLevel2
 * @property integer $MidInQtyLevel3
 * @property integer $MidInQtyLevel4
 * @property integer $ReturnQtyLevel1
 * @property integer $ReturnQtyLevel2
 * @property integer $ReturnQtyLevel3
 * @property integer $ReturnQtyLevel4
 * @property integer $ReplaceQtyLevel1
 * @property integer $ReplaceQtyLevel2
 * @property integer $ReplaceQtyLevel3
 * @property integer $ReplaceQtyLevel4
 * @property integer $SaleQtyLevel1
 * @property integer $SaleQtyLevel2
 * @property integer $SaleQtyLevel3
 * @property integer $SaleQtyLevel4
 * @property integer $FreeQtyLevel1
 * @property integer $FreeQtyLevel2
 * @property integer $FreeQtyLevel3
 * @property integer $FreeQtyLevel4
 * @property integer $MidOutQtyLevel1
 * @property integer $MidOutQtyLevel2
 * @property integer $MidOutQtyLevel3
 * @property integer $MidOutQtyLevel4
 * @property integer $EndQtyLevel1
 * @property integer $EndQtyLevel2
 * @property integer $EndQtyLevel3
 * @property integer $EndQtyLevel4
 * @property string $UpdateAt
 */
class Stock extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Stock the static model class
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
		return 'Stock';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('StartQtyLevel1, StartQtyLevel2, StartQtyLevel3, StartQtyLevel4, CurrentQtyLevel1, CurrentQtyLevel2, CurrentQtyLevel3, CurrentQtyLevel4, BadQtyLevel1, BadQtyLevel2, BadQtyLevel3, BadQtyLevel4, MidInQtyLevel1, MidInQtyLevel2, MidInQtyLevel3, MidInQtyLevel4, ReturnQtyLevel1, ReturnQtyLevel2, ReturnQtyLevel3, ReturnQtyLevel4, ReplaceQtyLevel1, ReplaceQtyLevel2, ReplaceQtyLevel3, ReplaceQtyLevel4, SaleQtyLevel1, SaleQtyLevel2, SaleQtyLevel3, SaleQtyLevel4, FreeQtyLevel1, FreeQtyLevel2, FreeQtyLevel3, FreeQtyLevel4, MidOutQtyLevel1, MidOutQtyLevel2, MidOutQtyLevel3, MidOutQtyLevel4, EndQtyLevel1, EndQtyLevel2, EndQtyLevel3, EndQtyLevel4', 'numerical', 'integerOnly'=>true),
			array('SaleId, ProductId', 'length', 'max'=>255),
			array('UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('SaleId, ProductId, StartQtyLevel1, StartQtyLevel2, StartQtyLevel3, StartQtyLevel4, CurrentQtyLevel1, CurrentQtyLevel2, CurrentQtyLevel3, CurrentQtyLevel4, BadQtyLevel1, BadQtyLevel2, BadQtyLevel3, BadQtyLevel4, MidInQtyLevel1, MidInQtyLevel2, MidInQtyLevel3, MidInQtyLevel4, ReturnQtyLevel1, ReturnQtyLevel2, ReturnQtyLevel3, ReturnQtyLevel4, ReplaceQtyLevel1, ReplaceQtyLevel2, ReplaceQtyLevel3, ReplaceQtyLevel4, SaleQtyLevel1, SaleQtyLevel2, SaleQtyLevel3, SaleQtyLevel4, FreeQtyLevel1, FreeQtyLevel2, FreeQtyLevel3, FreeQtyLevel4, MidOutQtyLevel1, MidOutQtyLevel2, MidOutQtyLevel3, MidOutQtyLevel4, EndQtyLevel1, EndQtyLevel2, EndQtyLevel3, EndQtyLevel4, UpdateAt', 'safe', 'on'=>'search'),
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
			'SaleId' => 'Sale',
			'ProductId' => 'Product',
			'StartQtyLevel1' => 'Start Qty Level1',
			'StartQtyLevel2' => 'Start Qty Level2',
			'StartQtyLevel3' => 'Start Qty Level3',
			'StartQtyLevel4' => 'Start Qty Level4',
			'CurrentQtyLevel1' => 'Current Qty Level1',
			'CurrentQtyLevel2' => 'Current Qty Level2',
			'CurrentQtyLevel3' => 'Current Qty Level3',
			'CurrentQtyLevel4' => 'Current Qty Level4',
			'BadQtyLevel1' => 'Bad Qty Level1',
			'BadQtyLevel2' => 'Bad Qty Level2',
			'BadQtyLevel3' => 'Bad Qty Level3',
			'BadQtyLevel4' => 'Bad Qty Level4',
			'MidInQtyLevel1' => 'Mid In Qty Level1',
			'MidInQtyLevel2' => 'Mid In Qty Level2',
			'MidInQtyLevel3' => 'Mid In Qty Level3',
			'MidInQtyLevel4' => 'Mid In Qty Level4',
			'ReturnQtyLevel1' => 'Return Qty Level1',
			'ReturnQtyLevel2' => 'Return Qty Level2',
			'ReturnQtyLevel3' => 'Return Qty Level3',
			'ReturnQtyLevel4' => 'Return Qty Level4',
			'ReplaceQtyLevel1' => 'Replace Qty Level1',
			'ReplaceQtyLevel2' => 'Replace Qty Level2',
			'ReplaceQtyLevel3' => 'Replace Qty Level3',
			'ReplaceQtyLevel4' => 'Replace Qty Level4',
			'SaleQtyLevel1' => 'Sale Qty Level1',
			'SaleQtyLevel2' => 'Sale Qty Level2',
			'SaleQtyLevel3' => 'Sale Qty Level3',
			'SaleQtyLevel4' => 'Sale Qty Level4',
			'FreeQtyLevel1' => 'Free Qty Level1',
			'FreeQtyLevel2' => 'Free Qty Level2',
			'FreeQtyLevel3' => 'Free Qty Level3',
			'FreeQtyLevel4' => 'Free Qty Level4',
			'MidOutQtyLevel1' => 'Mid Out Qty Level1',
			'MidOutQtyLevel2' => 'Mid Out Qty Level2',
			'MidOutQtyLevel3' => 'Mid Out Qty Level3',
			'MidOutQtyLevel4' => 'Mid Out Qty Level4',
			'EndQtyLevel1' => 'End Qty Level1',
			'EndQtyLevel2' => 'End Qty Level2',
			'EndQtyLevel3' => 'End Qty Level3',
			'EndQtyLevel4' => 'End Qty Level4',
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
		$criteria->compare('ProductId',$this->ProductId,true);
		$criteria->compare('StartQtyLevel1',$this->StartQtyLevel1);
		$criteria->compare('StartQtyLevel2',$this->StartQtyLevel2);
		$criteria->compare('StartQtyLevel3',$this->StartQtyLevel3);
		$criteria->compare('StartQtyLevel4',$this->StartQtyLevel4);
		$criteria->compare('CurrentQtyLevel1',$this->CurrentQtyLevel1);
		$criteria->compare('CurrentQtyLevel2',$this->CurrentQtyLevel2);
		$criteria->compare('CurrentQtyLevel3',$this->CurrentQtyLevel3);
		$criteria->compare('CurrentQtyLevel4',$this->CurrentQtyLevel4);
		$criteria->compare('BadQtyLevel1',$this->BadQtyLevel1);
		$criteria->compare('BadQtyLevel2',$this->BadQtyLevel2);
		$criteria->compare('BadQtyLevel3',$this->BadQtyLevel3);
		$criteria->compare('BadQtyLevel4',$this->BadQtyLevel4);
		$criteria->compare('MidInQtyLevel1',$this->MidInQtyLevel1);
		$criteria->compare('MidInQtyLevel2',$this->MidInQtyLevel2);
		$criteria->compare('MidInQtyLevel3',$this->MidInQtyLevel3);
		$criteria->compare('MidInQtyLevel4',$this->MidInQtyLevel4);
		$criteria->compare('ReturnQtyLevel1',$this->ReturnQtyLevel1);
		$criteria->compare('ReturnQtyLevel2',$this->ReturnQtyLevel2);
		$criteria->compare('ReturnQtyLevel3',$this->ReturnQtyLevel3);
		$criteria->compare('ReturnQtyLevel4',$this->ReturnQtyLevel4);
		$criteria->compare('ReplaceQtyLevel1',$this->ReplaceQtyLevel1);
		$criteria->compare('ReplaceQtyLevel2',$this->ReplaceQtyLevel2);
		$criteria->compare('ReplaceQtyLevel3',$this->ReplaceQtyLevel3);
		$criteria->compare('ReplaceQtyLevel4',$this->ReplaceQtyLevel4);
		$criteria->compare('SaleQtyLevel1',$this->SaleQtyLevel1);
		$criteria->compare('SaleQtyLevel2',$this->SaleQtyLevel2);
		$criteria->compare('SaleQtyLevel3',$this->SaleQtyLevel3);
		$criteria->compare('SaleQtyLevel4',$this->SaleQtyLevel4);
		$criteria->compare('FreeQtyLevel1',$this->FreeQtyLevel1);
		$criteria->compare('FreeQtyLevel2',$this->FreeQtyLevel2);
		$criteria->compare('FreeQtyLevel3',$this->FreeQtyLevel3);
		$criteria->compare('FreeQtyLevel4',$this->FreeQtyLevel4);
		$criteria->compare('MidOutQtyLevel1',$this->MidOutQtyLevel1);
		$criteria->compare('MidOutQtyLevel2',$this->MidOutQtyLevel2);
		$criteria->compare('MidOutQtyLevel3',$this->MidOutQtyLevel3);
		$criteria->compare('MidOutQtyLevel4',$this->MidOutQtyLevel4);
		$criteria->compare('EndQtyLevel1',$this->EndQtyLevel1);
		$criteria->compare('EndQtyLevel2',$this->EndQtyLevel2);
		$criteria->compare('EndQtyLevel3',$this->EndQtyLevel3);
		$criteria->compare('EndQtyLevel4',$this->EndQtyLevel4);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}