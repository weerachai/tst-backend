<?php

Yii::import('application.models._base.BaseSaleUnit');

class SaleUnit extends BaseSaleUnit
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'area' => array(self::BELONGS_TO, 'SaleArea', 'AreaId'),
			'employee' => array(self::BELONGS_TO, 'Employee', 'EmployeeId'),
			'device' => array(self::HAS_ONE, 'Device', 'SaleId'),
			'customers' => array(self::HAS_MANY, 'Customer', 'SaleId'),
			'orders' => array(self::HAS_MANY, 'ProductOrder', 'SaleId'),
			'controlNos' => array(self::HAS_MANY, 'ControlNo', 'SaleId'),
			'moneyTransfers' => array(self::HAS_MANY, 'MoneyTransfer', 'SaleId'),
			'stockTransfers' => array(self::HAS_MANY, 'StockTransfer', 'SaleId'),
			'stocks' => array(self::HAS_MANY, 'Stock', 'SaleId'),
		);
	}

	public function attributeLabels() {
		return array(
			'SaleId' => Yii::t('app', 'รหัสหน่วยขาย'),
			'SaleName' => Yii::t('app', 'ชื่อหน่วยขาย'),
			'SaleType' => Yii::t('app', 'ประเภทการขาย'),
			'EmployeeId' => Yii::t('app', 'รหัสพนักงานขาย'),
			'AreaId' => Yii::t('app', 'ชื่อพื้นที่ขาย'),
			'Active' => Yii::t('app', 'Active'),
		);
	}

	public function rules() {
		return array(
			array('SaleId, SaleName, SaleType, Active', 'required'),
			array('SaleId, SaleName, SaleType, EmployeeId, AreaId, Active', 'length', 'max'=>255),
			array('EmployeeId, AreaId', 'default', 'setOnEmpty' => true, 'value' => null),
			array('SaleId, SaleName, SaleType, EmployeeId, AreaId, Active', 'safe', 'on'=>'search'),
			array('AreaName, Supervisor, DeviceId, Username, Employee', 'safe', 'on'=>'search'),
		);
	}

	public $AreaName;
	public $Supervisor;
	public $DeviceId;
	public $Username;
	public $Employee;

	public function search() {
		$criteria = new CDbCriteria;
		$criteria->with = array( 'area', 'area.supervisor', 'device', 'employee' );
		
		$criteria->compare('SaleId', $this->SaleId, true);
		$criteria->compare('SaleName', $this->SaleName, true);
		$criteria->compare('SaleType', $this->SaleType, true);
		$criteria->addCondition('t.EmployeeId IS NOT NULL');
		$criteria->compare('t.EmployeeId', $this->EmployeeId, true);
		$criteria->addCondition('t.AreaId IS NOT NULL');
		$criteria->compare('AreaId', $this->AreaId, true);
		$criteria->compare('Active', $this->Active, true);
		$criteria->compare('area.AreaName', $this->AreaName, true);
		$criteria->compare('CONCAT(supervisor.FirstName," ",supervisor.LastName)', $this->Supervisor, true);
		$criteria->compare('device.DeviceId', $this->DeviceId, true);
		$criteria->compare('device.Username', $this->Username, true);
		$criteria->compare('CONCAT(employee.FirstName," ",employee.LastName)', $this->Employee, true);
	
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
        		'attributes'=>array(
            		'AreaName'=>array(
                		'asc'=>'area.AreaName',
                		'desc'=>'area.AreaName DESC',
            		),
             		'Supervisor'=>array(
                		'asc'=>'supervisor.FirstName, supervisor.LastName',
                		'desc'=>'supervisor.FirstName DESC, supervisor.LastName DESC',
            		),
              		'DeviceId'=>array(
                		'asc'=>'device.DeviceId',
                		'desc'=>'device.DeviceId DESC',
            		),
               		'Username'=>array(
                		'asc'=>'device.Username',
                		'desc'=>'device.Username DESC',
            		),
             		'Employee'=>array(
                		'asc'=>'employee.FirstName, employee.LastName',
                		'desc'=>'employee.FirstName DESC, employee.LastName DESC',
            		),
            	'*',
				),
			)
		));
	}

	public static function getOptions() {
		return CHtml::listData(SaleUnit::model()->findAll(), 
				'SaleId', 'SaleName'
			);
	}

	public static function getAvailableOptions() {
		return CHtml::listData(SaleUnit::model()->findAll('EmployeeId IS NULL'), 
				'SaleId', 'SaleName'
			);
	}

	public static function getUnassigendOptions() {
		return CHtml::listData(SaleUnit::model()->with('customers')->findAll('CustomerId IS NULL'), 
				'SaleId', 'SaleName'
			);
	}

	public static function getAssigendOptions() {
		return CHtml::listData(SaleUnit::model()->with('customers')->findAll('CustomerId IS NOT NULL'), 
				'SaleId', 'SaleName'
			);
	}

}