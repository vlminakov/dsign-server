<?php

class PlayersController extends Controller
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
      array('allow',  // allow all users to perform 'index' and 'view' actions
        'actions'=>array('gettt', 'getFtpCredentials'),
        'users'=>array('*'),
      ),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'set_tt'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('@'),
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
		$model=new Players;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Players']))
		{
			$model->attributes=$_POST['Players'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$model=$this->loadModel($id);
      // Uncomment the following line if AJAX validation is needed
      // $this->performAjaxValidation($model);

    if(isset($_POST['Players']))
    {
      $model->attributes=$_POST['Players'];
      if($model->save())
        $this->redirect(array('view','id'=>$model->id));
    }

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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Players');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Players('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Players']))
			$model->attributes=$_GET['Players'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

  public function actionGettt()
  {
    if (isset($_GET['upid'])){
      $pCrit = new CDbCriteria();
      $pCrit->select = array(
        'id',
        'name',
        'description',
        'upid',
        'state',
        'group_id',
        'timetable_id',
        'user_id'
      );
      $pCrit->condition = 'upid=:get_upid';
      $pCrit->params = array(':get_upid'=>$_GET['upid']);
      $playerModel = Players::model()->find($pCrit);
      $ttid = $playerModel->timetable_id;
      $tt = Timetables::model('Timetables')->findByPk($ttid);
      echo $tt->content;
    }
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Players the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Players::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Players $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='players-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

  public function actionSet_tt(){
    //if (isset($_GET['pid']) && isset($_GET['tid'])){
      $model = $this->loadModel($_REQUEST['pid']);
      $model->timetable_id = $_REQUEST['tid'];
      if ($model->save()){
        echo 'ok';
      }
    //}
  }

  public function actionGetFtpCredentials(){
    if (isset($_REQUEST['upid'])){
      $pModel = Players::model('Players')->find('upid=:upid', array(':upid'=>$_REQUEST['upid']));
      if ($pModel === null)
        return;
      $uModel = Users::model('Users')->find('id=:uid', array(':uid'=>$pModel->user_id));
      $email = $uModel->email;
      $pass = $uModel->password;
      $res = array(
        'email'=>$email,
        'password'=>$pass
      );
      echo json_encode($res);
    }
  }
}
