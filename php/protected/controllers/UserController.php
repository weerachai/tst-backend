<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('view','update'),
                                'roles'=>array('user'),
			),
			array('allow',
                                'actions'=>array('admin','create','delete'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
          // check the bizrule for this user
          if (!Yii::app()->user->checkAccess('updateSelf', $id) &&
              !Yii::app()->user->checkAccess('admin'))
            throw new CHttpException(403, Yii::t('application', 'You are
not authorized to perform this action'));

		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;
                $model->scenario = 'create';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
                        if (!empty($model->password))
                          $model->password = md5($model->password);

			if($model->save()) {
                          $auth=Yii::app()->authManager;
                          $auth->assign($model->role, $model->id);
                          $auth->save();
                          $this->redirect(array('view','id'=>$model->id));
                        }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
          // check the bizrule for this user
          if (!Yii::app()->user->checkAccess('updateSelf', $id) &&
              !Yii::app()->user->checkAccess('admin'))
            throw new CHttpException(403, Yii::t('application', 'You are
not authorized to perform this action'));

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
                  $old_role = $model->role;
                  $old_password = $model->password;

                  $model->attributes=$_POST['User'];
                  if (!empty($model->password))
                    $model->password = md5($model->password);
                  else
                    $model->password = $old_password;
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
		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
          $model = $this->loadModel($id);
          $auth=Yii::app()->authManager;
          $auth->revoke($model->role, $model->id);
          $auth->save();
          $model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
