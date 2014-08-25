<?php
/* @var $this TimetablesController */
/* @var $model Timetables */

$this->breadcrumbs=array(
	'Timetables'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Timetables', 'url'=>array('index')),
	array('label'=>'Manage Timetables', 'url'=>array('admin')),
);
?>

<h1>Create Timetables</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>