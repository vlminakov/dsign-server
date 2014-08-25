<?php
/* @var $this TimetablesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Timetables',
);

$this->menu=array(
	array('label'=>'Create Timetables', 'url'=>array('create')),
	array('label'=>'Manage Timetables', 'url'=>array('admin')),
);
?>

<h1>Timetables</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
