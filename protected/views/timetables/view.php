<?php
/* @var $this TimetablesController */
/* @var $model Timetables */

$this->breadcrumbs=array(
	'Timetables'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Timetables', 'url'=>array('index')),
	array('label'=>'Create Timetables', 'url'=>array('create')),
	array('label'=>'Update Timetables', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Timetables', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Timetables', 'url'=>array('admin')),
);
?>

<h1>View Timetables #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'user_id',
		'content',
	),
)); ?>
