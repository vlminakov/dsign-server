<?php
/* @var $this TimetablesController */
/* @var $model Timetables */

$this->breadcrumbs=array(
	'Timetables'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Timetables', 'url'=>array('index')),
	array('label'=>'Create Timetables', 'url'=>array('create')),
	array('label'=>'View Timetables', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Timetables', 'url'=>array('admin')),
);
?>

<h1>Update Timetables <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>