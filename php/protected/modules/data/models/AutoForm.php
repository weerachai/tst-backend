<?php

class AutoForm extends CFormModel
{
	public $tables ;
	public $folder ;
	public $type ;
	public $len ;
	public $unit ;

	public function rules()
	{
		if(!isset($this->scenario))
			$this->scenario = 'auto';

		return array(
			array('tables,folder,type,len,unit','required'),
			array('len','numerical','integerOnly'=>true,'min'=>1),
		);
	}
	public function afterValidate()
	{
		if ($this->unit == 'minute' && $this->len > 30)
	    {
	    	$this->addError('len', Yii::t('user', 'กรุณาระบุเวลาระหว่าง 1-30 นาที'));
	        return false;
	    }
		if ($this->unit == 'hour' && $this->len > 12)
	    {
	    	$this->addError('len', Yii::t('user', 'กรุณาระบุเวลาระหว่าง 1-12 ชั่วโมง'));
	        return false;
	    }
		if ($this->unit == 'day' && $this->len > 15)
	    {
	    	$this->addError('len', Yii::t('user', 'กรุณาระบุเวลาระหว่าง 1-15 วัน'));
	        return false;
	    }
		if ($this->unit == 'month' && $this->len > 6)
	    {
	    	$this->addError('len', Yii::t('user', 'กรุณาระบุเวลาระหว่าง 1-6 เดือน'));
	        return false;
	    }
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
