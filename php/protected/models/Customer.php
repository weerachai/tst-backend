<?php

/**
 * This is the model class for table "Customer".
 *
 * The followings are the available columns in table 'Customer':
 * @property string $CustomerId
 * @property string $DeviceId
 * @property string $SaleId
 * @property string $Title
 * @property string $CustomerName
 * @property string $Type
 * @property string $Trip1
 * @property string $Trip2
 * @property string $Trip3
 * @property string $Province
 * @property string $District
 * @property string $SubDistrict
 * @property string $ZipCode
 * @property string $AddrNo
 * @property string $Moo
 * @property string $Village
 * @property string $Soi
 * @property string $Road
 * @property string $Phone
 * @property string $ContactPerson
 * @property string $Promotion
 * @property integer $CreditTerm
 * @property string $CreditLimit
 * @property string $OverCreditType
 * @property string $Due
 * @property string $PoseCheck
 * @property string $ReturnCheck
 * @property string $NewFlag
 * @property string $UpdateAt
 */
class Customer extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Customer the static model class
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
		return 'Customer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('CustomerId, DeviceId, SaleId, Title, CustomerName, Type, Province, District, SubDistrict, ZipCode, CreditTerm, CreditLimit, OverCreditType, Due, PoseCheck, ReturnCheck, NewFlag', 'required'),
			array('CreditTerm', 'numerical', 'integerOnly'=>true),
			array('CustomerId, DeviceId, SaleId, Title, CustomerName, Type, Trip1, Trip2, Trip3, Province, District, SubDistrict, ZipCode, AddrNo, Moo, Village, Soi, Road, Phone, ContactPerson, Promotion, OverCreditType, NewFlag', 'length', 'max'=>255),
			array('CreditLimit, Due, PoseCheck, ReturnCheck', 'length', 'max'=>20),
			array('UpdateAt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('CustomerId, DeviceId, SaleId, Title, CustomerName, Type, Trip1, Trip2, Trip3, Province, District, SubDistrict, ZipCode, AddrNo, Moo, Village, Soi, Road, Phone, ContactPerson, Promotion, CreditTerm, CreditLimit, OverCreditType, Due, PoseCheck, ReturnCheck, NewFlag, UpdateAt', 'safe', 'on'=>'search'),
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
			'CustomerId' => 'Customer',
			'DeviceId' => 'Device',
			'SaleId' => 'Sale',
			'Title' => 'Title',
			'CustomerName' => 'Customer Name',
			'Type' => 'Type',
			'Trip1' => 'Trip1',
			'Trip2' => 'Trip2',
			'Trip3' => 'Trip3',
			'Province' => 'Province',
			'District' => 'District',
			'SubDistrict' => 'Sub District',
			'ZipCode' => 'Zip Code',
			'AddrNo' => 'Addr No',
			'Moo' => 'Moo',
			'Village' => 'Village',
			'Soi' => 'Soi',
			'Road' => 'Road',
			'Phone' => 'Phone',
			'ContactPerson' => 'Contact Person',
			'Promotion' => 'Promotion',
			'CreditTerm' => 'Credit Term',
			'CreditLimit' => 'Credit Limit',
			'OverCreditType' => 'Over Credit Type',
			'Due' => 'Due',
			'PoseCheck' => 'Pose Check',
			'ReturnCheck' => 'Return Check',
			'NewFlag' => 'New Flag',
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

		$criteria->compare('CustomerId',$this->CustomerId,true);
		$criteria->compare('DeviceId',$this->DeviceId,true);
		$criteria->compare('SaleId',$this->SaleId,true);
		$criteria->compare('Title',$this->Title,true);
		$criteria->compare('CustomerName',$this->CustomerName,true);
		$criteria->compare('Type',$this->Type,true);
		$criteria->compare('Trip1',$this->Trip1,true);
		$criteria->compare('Trip2',$this->Trip2,true);
		$criteria->compare('Trip3',$this->Trip3,true);
		$criteria->compare('Province',$this->Province,true);
		$criteria->compare('District',$this->District,true);
		$criteria->compare('SubDistrict',$this->SubDistrict,true);
		$criteria->compare('ZipCode',$this->ZipCode,true);
		$criteria->compare('AddrNo',$this->AddrNo,true);
		$criteria->compare('Moo',$this->Moo,true);
		$criteria->compare('Village',$this->Village,true);
		$criteria->compare('Soi',$this->Soi,true);
		$criteria->compare('Road',$this->Road,true);
		$criteria->compare('Phone',$this->Phone,true);
		$criteria->compare('ContactPerson',$this->ContactPerson,true);
		$criteria->compare('Promotion',$this->Promotion,true);
		$criteria->compare('CreditTerm',$this->CreditTerm);
		$criteria->compare('CreditLimit',$this->CreditLimit,true);
		$criteria->compare('OverCreditType',$this->OverCreditType,true);
		$criteria->compare('Due',$this->Due,true);
		$criteria->compare('PoseCheck',$this->PoseCheck,true);
		$criteria->compare('ReturnCheck',$this->ReturnCheck,true);
		$criteria->compare('NewFlag',$this->NewFlag,true);
		$criteria->compare('UpdateAt',$this->UpdateAt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}