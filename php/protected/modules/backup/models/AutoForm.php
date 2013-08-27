<?php

class AutoForm extends CFormModel
{
	public $min ;

	public function rules()
	{
		if(!isset($this->scenario))
			$this->scenario = 'auto';

		return array(
			array('min','required'),
			array('min','numerical','integerOnly'=>true,'min'=>1),
		);
	}

	public function attributeLabels()
	{
		return array(
			'min'=>'ช่วงเวลา',
		);
	}
	
}
