<?php

class AutoForm extends CFormModel
{
	public $tables ;
	public $folder ;
	public $type ;
	public $min ;

	public function rules()
	{
		if(!isset($this->scenario))
			$this->scenario = 'auto';

		return array(
			array('tables,folder,type,min','required'),
			array('min','numerical','integerOnly'=>true,'min'=>1),
		);
	}

	public function attributeLabels()
	{
		return array(
			'tables'=>'ข้อมูล',
			'folder'=>'Folder',
			'type'=>'ชนิดไฟล์',
			'min'=>'ช่วงเวลา',
		);
	}
	
}
