<?php

class TimetablesController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'save_tt', 'get_tt_list'),
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
	public function actionView($id = null, $name = null)
	{
    if ($name === null){
      $this->render('view',array(
        'model'=>$this->loadModel($id),
      ));
      return;
    } else {
      if (isset($_GET['name']) && $_GET['name'] !== ''){
        $cr = new CDbCriteria();
        $cr->select = array('id','name','user_id','content');
        $cr->condition = 'name=:name AND user_id=:user_id';
        $cr->params = array(
          ':name'=>$_GET['name'],
          ':user_id'=>Yii::app()->user->id
        );
        $model = Timetables::model('Timetables')->find($cr);
        $tt = new Timetable();
        $tt->id = $model->id;
        $tt->name = $model->name;
        $tt->user_id = $model->user_id;
        $tt->content = $model->content;
        echo json_encode($tt);
      }
    }
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Timetables;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Timetables']))
		{
			$model->attributes=$_POST['Timetables'];
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

		if(isset($_POST['Timetables']))
		{
			$model->attributes=$_POST['Timetables'];
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
		$dataProvider=new CActiveDataProvider('Timetables');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Timetables('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Timetables']))
			$model->attributes=$_GET['Timetables'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Timetables the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id, $act = 0)
	{
		$model=Timetables::model()->findByPk($id);
		if($model === null){
      if ($act === 0)
        throw new CHttpException(404,'The requested page does not exist.');
    }

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Timetables $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='timetables-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

  public function actionSave_tt(){
    $json_data = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
    $tt = new Timetable($json_data);
    //$tt = $json_data->Timetable;

    //$model = $this->loadModel($tt->id, 1);
    $model=Timetables::model('Timetables')->find('user_id=:user_id AND name=:name', array(':user_id'=>Yii::app()->user->id, ':name'=>$tt->name));
    if ($model === null){
      $model = new Timetables();
      $model->name = $tt->name;
      $model->user_id = Yii::app()->user->id;
      $model->content = $tt->content;
      $model->save();
    } else {
      $model->name = $tt->name;
      $model->user_id = Yii::app()->user->id;
      $model->content = $tt->content;
      $model->save();
    }
  }

  public function actionGet_tt_list(){
    $ttList = array();
    $searchResult = Timetables::model('Timetables')->findAll('user_id=:uid', array(':uid'=>Yii::app()->user->id));
    foreach($searchResult as $model){
      $tt = new Timetable();
      $tt->id = $model->id;
      $tt->name = $model->name;
      $tt->content = $model->content;
      $tt->user_id = $model->user_id;

      array_push($ttList, $tt);
    }
    echo json_encode($ttList);
  }
}
