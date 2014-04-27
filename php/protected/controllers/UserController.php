<?php

class UserController extends GxController {

	public $layout='//layouts/column2';

	public function filters() {
		return array('accessControl');
	}

	public function accessRules() {
		return array(
			array('allow', 
				'actions'=>array('index','password','view'),
				'roles'=>array('user'),
			),
			array('allow', 
				'actions'=>array('admin','create','update','delete'),
				'roles'=>array('manager'),
			),
			array('deny', 
				'users'=>array('*'),
			),
		);
	}

	public function actionView($id) {
		$model = $this->loadModel($id, 'User');
        if (!Yii::app()->user->checkAccess('admin') && $model->role!='user' && $model->id!=Yii::app()->user->getId())
            throw new CHttpException(403, Yii::t('application', 'You are
not authorized to perform this action'));

		$this->render('view', array(
			'model' => $model,
		));
	}

	public function actionCreate()
	{
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$hash = new myMD5();
            if (!empty($model->password))
                $model->password = $hash->hash($model->password);          
            if (!empty($model->repeat_password))
                $model->repeat_password = $hash->hash($model->repeat_password);

			if($model->save()) {
                $auth=Yii::app()->authManager;
                $auth->assign($model->role, $model->id);
                $auth->save();
                $this->redirect(array('view','id'=>$model->id));
            }
          	
		}
		$model->password = '';
        $model->repeat_password = '';
		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
        if (!Yii::app()->user->checkAccess('admin') && $model->role!='user' && $model->id!=Yii::app()->user->getId())
            throw new CHttpException(403, Yii::t('application', 'You are
not authorized to perform this action'));


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
            $old_role = $model->role;
            $old_password = $model->password;

            $model->attributes=$_POST['User'];
            $hash = new myMD5();
            if (empty($model->password) && empty($model->repeat_password)) {
            	$model->password = $old_password;
            	$model->repeat_password = $old_password;
            }
            if (!empty($model->password))
                $model->password = $hash->hash($model->password);          
            if (!empty($model->repeat_password))
                $model->repeat_password = $hash->hash($model->repeat_password);

            if($model->save()) {
                if (strcmp($old_role, $model->role) != 0) {
                      $auth=Yii::app()->authManager;
                      $auth->revoke($old_role, $model->id);
                      $auth->assign($model->role, $model->id);
                      $auth->save();
                }
                $this->redirect(array('view','id'=>$model->id));
            }
		}

        $model->password = '';
        $model->repeat_password = '';
		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionPassword($id)
	{
          // check the bizrule for this user
        if (!Yii::app()->user->checkAccess('updateSelf', $id))
            throw new CHttpException(403, Yii::t('application', 'You are
not authorized to perform this action'));

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
            $model->password=$_POST['User']['password'];
            $model->repeat_password=$_POST['User']['repeat_password'];
            $hash = new myMD5();
            if (!empty($model->password))
                $model->password = $hash->hash($model->password);          
            if (!empty($model->repeat_password))
                $model->repeat_password = $hash->hash($model->repeat_password);
            if($model->save()) {
                $this->redirect(array('view','id'=>$model->id));
            }
		}

        $model->password = '';
        $model->repeat_password = '';
		$this->render('password',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
        $model = $this->loadModel($id);
        if (!Yii::app()->user->checkAccess('admin') && $model->role!='user')
            throw new CHttpException(403, Yii::t('application', 'You are
not authorized to perform this action'));

        $auth=Yii::app()->authManager;
        $auth->revoke($model->role, $model->id);
        $auth->save();
        $model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionIndex() {
		if (Yii::app()->user->checkAccess('manager'))
			$this->actionAdmin();
		else
			$this->actionView(Yii::app()->user->getId());		
	}

	public function actionAdmin() {
		if (Yii::app()->user->checkAccess('admin'))
			$where = '1';
		else
			$where = 'role = "user" OR id = ' . Yii::app()->user->getId();
		$sql = <<<SQL
		SELECT id, username, name, role, employee 
		FROM User
		WHERE $where
		ORDER BY id
SQL;

		// Create filter model and set properties
		$filtersForm = new FiltersForm;
		if (isset($_GET['FiltersForm']))
		    $filtersForm->filters=$_GET['FiltersForm'];
		 
		// Get rawData and create dataProvider
		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		$filteredData = $filtersForm->filter($rawData);
		$dataProvider = new CArrayDataProvider($filteredData, array(
    		'sort'=>array(
        		'attributes'=>array(
           	 	 'id', 'username', 'name', 'role', 'employee'
        		),
    		),
    		'pagination'=>array(
        		'pageSize'=>10,
    		),
		));

		// Render
		$this->render('admin', array(
    		'filtersForm' => $filtersForm,
    		'dataProvider' => $dataProvider,
		));
	}

	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}