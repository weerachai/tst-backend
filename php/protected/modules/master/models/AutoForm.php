<?php

class AutoForm extends CFormModel
{
	public $day ;

	public function rules()
	{
		if(!isset($this->scenario))
			$this->scenario = 'auto';

		return array(
			array('day','required'),
			array('day','numerical','integerOnly'=>true,'min'=>1,'max'=>31),
		);
	}

	public function attributeLabels()
	{
		return array(
			'day'=>'วันที่',
		);
	}
	
}
