<?php

class BrowseController extends GxController
{
	public function filters() {
		return array('accessControl');
	}

	public function accessRules() {
		return array(
			array('allow', 
				'actions'=>array('index','download','delete','upload'),
				'expression'=>'$user->checkAccess("operator")', 
			),
			array('deny', 
				'users'=>array('*'),
			),
		);
	}
	public function actionIndex($folder=null,$type='txt')
	{
		$dir = Yii::app()->basePath . "/../../files";
		$files = scandir($dir);
		$folders = array();
		foreach ($files as $file) {
			if ($file != '.' && $file != '..')
				$folders[$file] = $file;
		}

		if (!isset($folder))
			$folder = array_shift(array_keys($folders));

		$path = "$dir/$folder/";
		$dataArray = array();
		$list_files = glob("$dir/$folder/*.$type");
		if ($list_files )
		{
			$list = array_map('basename',$list_files);
			sort($list);

			foreach ( $list as $id=>$filename )
			{
				$columns = array();
				$columns['id'] = $id;
				$columns['name'] = basename ( $filename);
				$columns['folder'] = $folder;
				$columns['size'] = floor(filesize ( $path. $filename)/ 1024) .' KB';
				$columns['create_time'] = date( DATE_RFC822, filectime($path .$filename) );
				$dataArray[] = $columns;
			}
		}
		$dataProvider = new CArrayDataProvider($dataArray);
		$this->render('index', array(
			'folder' => $folder,
			'type' => $type,
			'folders' => $folders,
			'dataProvider' => $dataProvider,
		));
	}

	public function actionDownload($file = null, $folder = null)
	{
		if ( isset($file) && isset($folder))
		{
			$dir = Yii::app()->basePath . "/../../files/$folder/";
			$downloadFile = $dir . basename($file);
			if ( file_exists($downloadFile))
			{
				$request = Yii::app()->getRequest();
				$request->sendFile(basename($downloadFile),file_get_contents($downloadFile));
			}
		}
		throw new CHttpException(404, Yii::t('app', 'File not found'));
	}

	public function actionDelete($file = null, $folder = null)
	{
		if ( isset($file))
		{
			$dir = Yii::app()->basePath . "/../../files/$folder/";
			$deleteFile = $dir . basename($file);
			if ( file_exists($deleteFile))
			unlink($deleteFile);
		}
		else throw new CHttpException(404, Yii::t('app', 'File not found'));
		$this->actionIndex();
	}

	public function actionUpload()
	{
		$model= new UploadForm('upload');
		
		$dir = Yii::app()->basePath . "/../../files";
		$files = scandir($dir);
		$folders = array();
		foreach ($files as $file) {
			if ($file != '.' && $file != '..')
				$folders[$file] = $file;
		}

		if(isset($_POST['UploadForm']))
		{
			$model->attributes = $_POST['UploadForm'];
			$dir = Yii::app()->basePath . "/../../files/".$model->folder."/";
			$model->upload_file = CUploadedFile::getInstance($model,'upload_file');
			if ($model->validate())
				if($model->upload_file->saveAs($dir . $model->upload_file))
				{
					chmod($dir . $model->upload_file, 0775);
					// redirect to success page
					$this->redirect(array('index'));
				}
		}

		$this->render('upload',array('model'=>$model,'folders'=>$folders));
	}
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}