<?php
/* @var $this StatisticsController */
/* @var $model Statistics */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'statistics-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'filename'); ?>
		<?php echo $form->textField($model,'filename',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'filename'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php echo $form->textField($model,'date',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time'); ?>
		<?php echo $form->textField($model,'time',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'upid'); ?>
		<?php echo $form->textField($model,'upid',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'upid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pname'); ?>
		<?php echo $form->textArea($model,'pname',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'pname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pdescription'); ?>
		<?php echo $form->textArea($model,'pdescription',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'pdescription'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'uid'); ?>
		<?php echo $form->textField($model,'uid'); ?>
		<?php echo $form->error($model,'uid'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->