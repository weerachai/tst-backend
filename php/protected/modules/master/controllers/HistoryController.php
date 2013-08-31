<?php

class HistoryController extends GxController
{
	public function actionIndex()
	{
		if (isset($_POST['yt0'])) {
			$helper = new CreateHistory;
			$helper->generate();
			$this->render('success');
		}
		$this->render('index');
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
				foreach($jobs_obj as $job) {
					if ($job->getCommandName() == 'history') {
						$job->setMinute('0');
						$job->setHour('0');
						$job->setDay($model->day);
						$found = true;
						break;
					}
				}
				if (!$found) {
		    		$cron->addApplicationJob('yiicmd', 'history', array(), '0', '0', $model->day);
				}
				$cron->saveCronFile();
				$cron->saveToCrontab();
				$this->render('success');
			}
		}
		$this->render('auto',array('model'=>$model));
	}

	public function actionStop()
	{
		$cron = new Crontab('my_crontab'); 
		//		$cron->eraseJobs();
		$jobs_obj = $cron->getJobs();
		$found = false;
		foreach($jobs_obj as $i=>$job) {
			if ($job->getCommandName() == 'history') {
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