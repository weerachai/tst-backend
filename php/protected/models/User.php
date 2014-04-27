<?php

Yii::import('application.models._base.BaseUser');

class User extends BaseUser
{
	public $repeat_password;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function attributeLabels() {
		return array(
			'password' => Yii::t('app', 'รหัสผ่าน'),
			'repeat_password' => Yii::t('app', 'รหัสผ่านอีกครั้ง'),
			'name' => Yii::t('app', 'ชื่อ'),
		);
	}

	public function rules() {
		return array(
			array('username, password, repeat_password, name, role', 'required'),
			array('username', 'unique'),
			array('username, name, role, employee', 'length', 'max'=>255),
			array('employee', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, username, name, role, employee', 'safe', 'on'=>'search'),
            array('password', 'compare', 'compareAttribute'=>'repeat_password'),
		);
	}
}