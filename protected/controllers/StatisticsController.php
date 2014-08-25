<?php

class StatisticsController extends Controller
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
				'actions'=>array('index','view', 'add_stat'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'get_stat', 'getUserFiles'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('*'),
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
		$model=new Statistics;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Statistics']))
		{
			$model->attributes=$_POST['Statistics'];
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

		if(isset($_POST['Statistics']))
		{
			$model->attributes=$_POST['Statistics'];
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
		$dataProvider=new CActiveDataProvider('Statistics');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Statistics('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Statistics']))
			$model->attributes=$_GET['Statistics'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Statistics the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Statistics::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Statistics $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='statistics-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

  public function actionGet_stat(){
    $fname = $_GET['filename'];
    $uid = Yii::app()->user->id;
    $report = array();
    $searchResult = Statistics::model('Statistics')->findAll('filename=:filename AND uid=:uid', array(':filename'=>$fname, ':uid'=>$uid));
    foreach($searchResult as $model){
      $stat = new Statistic();
      $stat->id = $model->id;
      $stat->filename = $model->filename;
      $stat->date = $model->date;
      $stat->time = $model->time;
      $stat->upid = $model->upid;
      $stat->pname = $model->pname;
      $stat->pdescription = $model->pdescription;
      $stat->uid = $model->uid;
      array_push($report, $stat);
    }
    echo json_encode($report);
  }

  public function actionAdd_stat(){
    if (!isset($GLOBALS['HTTP_RAW_POST_DATA']))
      return;
    $json_stat = $GLOBALS['HTTP_RAW_POST_DATA'];
    $_stat = json_decode($json_stat);
    $statToSave = new Statistic();
    $statToSave->filename = $_stat->filename;
    $statToSave->date = $_stat->date;
    $statToSave->time = $_stat->time;
    $statToSave->upid = $_stat->upid;

    $playerModel = Players::model('Players')->find('upid=:upid', array(':upid'=>$_stat->upid));
    if ($playerModel !== null){
      $statToSave->pname = $playerModel->name;
      $statToSave->pdescription = $playerModel->description;
      $statToSave->uid = $playerModel->user_id;
    }
    $attrs = (array) $statToSave;
    $statisticsModel= new Statistics;
    $statisticsModel->attributes = $attrs;
    if ($statisticsModel->save()){
      echo 'ok';
    }
  }

  public function actionGetUserFiles(){
    $fileList = array();
    $searchResult = Statistics::model('Statistics')->findAll('uid=:uid', array(':uid'=>Yii::app()->user->id));
    foreach ($searchResult as $model){
      $name = $model->filename;
      $found = false;
      foreach($fileList as $file){
        if ($file === $name){
          $found = true;
          break;
        }
      }
      if ($found){
        continue;
      }
      array_push($fileList, $model->filename);
    }
    echo json_encode($fileList);
  }
}