<?php
/* @var $this StatisticsController */
/* @var $data Statistics */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('filename')); ?>:</b>
	<?php echo CHtml::encode($data->filename); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time')); ?>:</b>
	<?php echo CHtml::encode($data->time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('upid')); ?>:</b>
	<?php echo CHtml::encode($data->upid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pname')); ?>:</b>
	<?php echo CHtml::encode($data->pname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pdescription')); ?>:</b>
	<?php echo CHtml::encode($data->pdescription); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('uid')); ?>:</b>
	<?php echo CHtml::encode($data->uid); ?>
	<br />
</div>