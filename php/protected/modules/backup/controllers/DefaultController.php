<?php
/**
 * Backup
 *
 * Yii module to backup, restore databse
 *
 * @version 1.0
 * @author Shiv Charan Panjeta <shiv@toxsl.com> <shivcharan.panjeta@outlook.com>
 */
class DefaultController extends GxController
{

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	public function filters() {
		return array('accessControl');
	}

	public function accessRules() {
		return array(
			array('allow', 
				'actions'=>array('index','create','download','restore','delete','auto','stop','upload'),
				'expression'=>'$user->checkAccess("operator")', 
			),
			array('deny', 
				'users'=>array('*'),
			),
		);
	}

	public function actionCreate()
	{
		$helper = new BackupDb;

		$tables = $helper->getTables();

		if(!$helper->StartBackup())
		{
			//render error
			$this->render('create');
			return;
		}

		foreach($tables as $tableName)
		{
			$helper->getColumns($tableName);
		}
		foreach($tables as $tableName)
		{
			$helper->getData($tableName);
		}
		$helper->EndBackup();

		$this->redirect(array('index'));
	}

	public function actionDelete($file = null)
	{
		$this->updateMenuItems();
		if ( isset($file))
		{
			$sqlFile = Yii::app()->basePath .'/../../backup/' . basename($file);
			if ( file_exists($sqlFile))
			unlink($sqlFile);
		}
		else throw new CHttpException(404, Yii::t('app', 'File not found'));
		$this->actionIndex();
	}

	public function actionDownload($file = null)
	{
		$this->updateMenuItems();
		if ( isset($file))
		{
			$sqlFile = Yii::app()->basePath .'/../../backup/' . basename($file);
			if ( file_exists($sqlFile))
			{
				$request = Yii::app()->getRequest();
				$request->sendFile(basename($sqlFile),file_get_contents($sqlFile));
			}
		}
		throw new CHttpException(404, Yii::t('app', 'File not found'));
	}

	public function actionIndex()
	{
		$this->updateMenuItems();
		$path = Yii::app()->basePath .'/../../backup/';
		$dataArray = array();
		
		$list_files = glob($path .'*.sql');
		if ($list_files )
		{
			$list = array_map('basename',$list_files);
			sort($list);

			foreach ( $list as $id=>$filename )
			{
				$columns = array();
				$columns['id'] = $id;
				$columns['name'] = basename ( $filename);
				$columns['size'] = floor(filesize ( $path. $filename)/ 1024) .' KB';
				$columns['create_time'] = date( DATE_RFC822, filectime($path .$filename) );
				$dataArray[] = $columns;
			}
		}
		$dataProvider = new CArrayDataProvider($dataArray);
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionRestore($file)
	{
		$this->updateMenuItems();
		$sqlFile = Yii::app()->basePath .'/../../backup/' . basename($file);
		$helper = new BackupDb;
		$helper->execSqlFile($sqlFile);
		$this->render('success');
	}

	public function actionUpload()
	{
		$this->updateMenuItems();
		$model= new UploadForm('upload');
		if(isset($_POST['UploadForm']))
		{
			$model->attributes = $_POST['UploadForm'];
			$model->upload_file = CUploadedFile::getInstance($model,'upload_file');
			if ($model->validate())
				if($model->upload_file->saveAs(Yii::app()->basePath .'/../../backup/' . $model->upload_file))
				{
					$this->render('success');
					return;
				}
		}

		$this->render('upload',array('model'=>$model));
	}

	public function actionAuto()
	{
		$this->updateMenuItems();
		$model= new AutoForm('auto');
		if(isset($_POST['AutoForm']))
		{
			$model->attributes = $_POST['AutoForm'];
			if ($model->validate()) {
				$cron = new Crontab('my_crontab'); 
				//		$cron->eraseJobs();
				$jobs_obj = $cron->getJobs();
				$found = false;
				if ($model->unit == 'minute') {
					$minute = '*/'.$model->len;
					$hour = '*';
					$day = '*';
					$month = '*';
				} else if ($model->unit == 'hour') {
					$minute = '0';
					$hour = '*/'.$model->len;
					$day = '*';
					$month = '*';
				} else if ($model->unit == 'day') {
					$minute = '0';
					$hour = '0';
					$day = '*/'.$model->len;
					$month = '*';
				} else {
					$minute = '0';
					$hour = '0';
					$day = '1';
					$month = '*/'.$model->len;
				} 
				foreach($jobs_obj as $job) {
					if ($job->getCommandName() == 'backup') {
						$job->setMinute($minute);
						$job->setHour($hour);
						$job->setDay($day);
						$job->setMonth($month);
						$found = true;
						break;
					}
				}
				if (!$found) {
		    		$cron->addApplicationJob('yiicmd', 'backup', array(), $minute, $hour, $day, $month);
				}
				$cron->saveCronFile();
				$cron->saveToCrontab();
				$this->render('success');
				return;
			}
		}
		$this->render('auto',array('model'=>$model));
	}

	public function actionStop()
	{
		$this->updateMenuItems();
		$cron = new Crontab('my_crontab'); 
		//		$cron->eraseJobs();
		$jobs_obj = $cron->getJobs();
		$found = false;
		foreach($jobs_obj as $i=>$job) {
			if ($job->getCommandName() == 'backup') {
				$cron->removeJob($i);
				break;
			}
		}
		$cron->saveCronFile();
		$cron->saveToCrontab();
		$this->render('success');
	}

	protected function updateMenuItems($model = null)
	{
		// create static model if model is null
		if ( $model == null ) $model=new UploadForm('install');

		switch( $this->action->id)
		{
			case 'auto':
				{
					$this->menu[] = array('label'=>Yii::t('app', 'List Backup') . ' ' . $model->label(2), 'url'=>array('index'));
					$this->menu[] = array('label'=>Yii::t('app', 'Create Backup') . ' ' . $model->label(), 'url'=>array('create'));
					$this->menu[] = array('label'=>Yii::t('app', 'Stop Auto Backup') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('stop'), 'confirm'=>'กรุณายืนยัน'));
					$this->menu[] = array('label'=>Yii::t('app', 'Upload Backup') . ' ' . $model->label(), 'url'=>array('upload'));
				}
				break;
			case 'upload':
				{
					$this->menu[] = array('label'=>Yii::t('app', 'List Backup') . ' ' . $model->label(2), 'url'=>array('index'));
					$this->menu[] = array('label'=>Yii::t('app', 'Create Backup') . ' ' . $model->label(), 'url'=>array('create'));
					$this->menu[] = array('label'=>Yii::t('app', 'Set Auto Backup') . ' ' . $model->label(), 'url'=>array('auto'));
					$this->menu[] = array('label'=>Yii::t('app', 'Stop Auto Backup') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('stop'), 'confirm'=>'กรุณายืนยัน'));
				}
				break;
			default:
				{
					$this->menu[] = array('label'=>Yii::t('app', 'List Backup') . ' ' . $model->label(2), 'url'=>array('index'));
					$this->menu[] = array('label'=>Yii::t('app', 'Create Backup') . ' ' . $model->label(), 'url'=>array('create'));
					$this->menu[] = array('label'=>Yii::t('app', 'Set Auto Backup') . ' ' . $model->label(), 'url'=>array('auto'));
					$this->menu[] = array('label'=>Yii::t('app', 'Stop Auto Backup') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('stop'), 'confirm'=>'กรุณายืนยัน'));
					$this->menu[] = array('label'=>Yii::t('app', 'Upload Backup') . ' ' . $model->label(), 'url'=>array('upload'));
				}
				break;
		}
	}
}
