<?php

class GroupsController extends Controller
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
				'actions'=>array('index','view', 'savegroups'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'savegroups'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'savegroups'),
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
		$model=new Groups;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Groups']))
		{
			$model->attributes=$_POST['Groups'];
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

		if(isset($_POST['Groups']))
		{
			$model->attributes=$_POST['Groups'];
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
    if (Yii::app()->user->role === 'admin'){
      $dataProvider=new CActiveDataProvider('Groups');
      $this->render('index',array(
        'dataProvider'=>$dataProvider,
      ));
    } else {
      $criteria = new CDbCriteria;
      $criteria->select = array('id', 'name', 'description');
      $criteria->condition = 'user_id=:user_id';
      $criteria->params = array(':user_id' => Yii::app()->user->id);
      $res = Groups::model()->findAll($criteria);
      $groups = array();
      if (count($res) === 0){
        $search = Players::model('Players')->findAll('user_id=:uid', array(':uid'=>Yii::app()->user->id));
        foreach($search as $player){
          $newGroup = new Group();
          $newGroup->id = 0;
          $newGroup->name = $player->name;
          $newGroup->description = $player->description;
          $pl = new Player();
          $pl->id = (int)$player->id;
          $pl->upid = $player->upid;
          $pl->name = $player->name;
          $pl->description = $player->description;
          $pl->state = (int)$player->state;
          $pl->ttId = $player->timetable_id;
          $newGroup->addPlayer($pl);
          array_push($groups, $newGroup);
        }
        echo json_encode($groups);
        exit;
      }

      foreach($res as $gr){
        $ng = new Group();
        $ng->id = $gr->id;
        $ng->name = $gr->name;
        $ng->description = $gr->description;
        $plCrit = new CDbCriteria;
        $plCrit->select = array('id', 'name', 'description', 'state', 'upid', 'timetable_id');
        $plCrit->condition = 'group_id=:id';
        $plCrit->params = array(
          ':id' => $gr->id
        );
        $plrs = Players::model()->findAll($plCrit);
        foreach ($plrs as $p) {
          $pl = new Player();
          $pl->id = (int)$p->id;
          $pl->upid = $p->upid;
          $pl->name = $p->name;
          $pl->description = $p->description;
          $pl->state = (int)$p->state;
          $pl->ttId = $p->timetable_id;
          $ng->addPlayer($pl);
        }
        array_push($groups, $ng);
        unset($ng);
      }
      echo json_encode($groups);
      unset($res);
      unset($groups);
    }
	}

  public function actionSavegroups()
  {
    if (isset($_POST['data'])){
      $groups = array();
      $groups = json_decode($_POST['data']);
      foreach ($groups as $value) {
        $players = array();
        $players = $value->players;
        foreach ($players as $plVal) {
          $pl = new Player();
          $pl = $plVal;
          $pModel = Players::model('Players')->findByPk($pl->id);
          $attrs = array(
            'id'=>$pModel->id,
            'name'=>$pModel->name,
            'description'=>$pModel->description,
            'upid'=>$pModel->upid,
            'state'=>$pModel->state,
            'group_id'=>$value->id,
            'timetable_id'=>$pModel->timetable_id,
            'user_id'=>$pModel->user_id
          );
          $pModel->attributes = $attrs;
          $pModel->save();
        }
      }
    }
  }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
    if (Yii::app()->user->role !== 'admin'){
      $this->redirect('index');
    }
		$model=new Groups('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Groups']))
			$model->attributes=$_GET['Groups'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Groups the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Groups::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Groups $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='groups-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
