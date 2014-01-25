<?php

class ExportController extends GxController
{
			
	private $tableList = array(
			"Customer" => "Customer",
			"Product" => "Product",
			);

	public function actionIndex()
	{

		if (isset($_POST['Table'])) {
			$table = $_POST['Table'];
			$folder = $_POST['Folder'];
			$fileName = $_POST['FileName'];
			$fileType = $_POST['FileType'];
			$fieldList = $_POST['FieldList'];

			$helper = new ExportDb;
			$fileName = Yii::app()->basePath . "/../../files/$folder/$fileName";
			if ($fileType == 'txt') {
				$helper->exportText($table, $fieldList, $fileName);
			} else {
				$helper->exportExcel($table, $fieldList, $fileName);
			}
			$this->redirect(array('/data/browse','folder'=>$folder,'type'=>$fileType));
		}

		$dir = Yii::app()->basePath . "/../../files";
		$files = scandir($dir);
		$folderList = array();
		foreach ($files as $file) {
			if ($file != '.' && $file != '..')
				$folderList[$file] = $file;
		}
		$fieldList = array();
		foreach (Yii::app()->db->schema->getTable('Customer')->columns as $column) {
			$fieldList[$column->name] = $column->name;
		}
		$this->render('index', array(
    		'tableList' => $this->tableList,
    		'folderList' => $folderList,
    		'defaultFileName' => 'Customer-'.date("YmdHis"),
    		'fieldList' => $fieldList
		));
	}

	public function actionAuto()
	{
		$model= new AutoForm('auto');
		if(isset($_POST['AutoForm']))
		{
			$model->attributes = $_POST['AutoForm'];
			if ($model->validate()) {
				$cron = new Crontab('my_crontab'); 
				//		$cron->eraseJobs();
				$jobs_obj = $cron->getJobs();
				$found = false;
				$minute = $model->unit == 'minute'?'*/'.$model->len:'*';
				$hour = $model->unit == 'hour'?'*/'.$model->len:'*';
				$day = $model->unit == 'day'?'*/'.$model->len:'*';
				$month = $model->unit == 'month'?'*/'.$model->len:'*';				$params = array($model->folder,$model->type);
				foreach ($model->tables as $table)
					$params[] = $table;
				foreach($jobs_obj as $job) {
					if ($job->getCommandName() == 'export') {
						$job->setParams($params);
						$job->setMinute($minute);
						$job->setHour($hour);
						$job->setDay($day);
						$job->setMonth($month);
						$found = true;
						break;
					}
				}
				if (!$found) {
		    		$cron->addApplicationJob('yiicmd', 'export', $params, $minute, $hour, $day, $month);
				}
				$cron->saveCronFile();
				$cron->saveToCrontab();
				$this->render('success');
				return;
			}
		}
		$dir = Yii::app()->basePath . "/../../files";
		$files = scandir($dir);
		$folderList = array();
		foreach ($files as $file) {
			if ($file != '.' && $file != '..')
				$folderList[$file] = $file;
		}
		$this->render('auto', array(
			'model' => $model,
    		'tableList' => $this->tableList,
    		'folderList' => $folderList,
    	));
	}

	public function actionStop()
	{
		$cron = new Crontab('my_crontab'); 
		//		$cron->eraseJobs();
		$jobs_obj = $cron->getJobs();
		$found = false;
		foreach($jobs_obj as $i=>$job) {
			if ($job->getCommandName() == 'export') {
				$cron->removeJob($i);
				break;
			}
		}
		$cron->saveCronFile();
		$cron->saveToCrontab();
		$this->render('success');
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