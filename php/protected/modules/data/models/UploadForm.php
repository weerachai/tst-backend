<?php
/**
 * UploadForm class.
 * UploadForm is the data structure for keeping
 */
class UploadForm extends CFormModel
{
	public $upload_file ;
	public $folder ;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		if(!isset($this->scenario))
		$this->scenario = 'upload';

		return array(
		array('upload_file, folder', 'required'),
		array('upload_file','file','types'=>'txt,xls','allowEmpty'=>false),		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'upload_file'=>'Upload File',
		);
	}
	public static function label($n = 1) {
		return Yii::t('app', 'File|Files', $n);
	}	
}
