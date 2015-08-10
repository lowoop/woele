<?php
/* @var $this OrderLogController */
/* @var $model OrderLog */
/* @var $form CActiveForm */
?>

<div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Series</h5>
        </div>
        <div class="widget-content nopadding">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-log-form',
	'htmlOptions'=>array('class'=>'form-horizontal'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="control-group">
		<?php echo $form->labelEx($model,'oid'); ?>
		<div class="controls">
		<?php echo $form->textField($model,'oid'); ?>
		<?php echo $form->error($model,'oid'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'rid'); ?>
		<div class="controls">
		<?php echo $form->textField($model,'rid'); ?>
		<?php echo $form->error($model,'rid'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'uid'); ?>
		<div class="controls">
		<?php echo $form->textField($model,'uid'); ?>
		<?php echo $form->error($model,'uid'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'status'); ?>
		<div class="controls">
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'desc'); ?>
		<div class="controls">
		<?php echo $form->textField($model,'desc',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'desc'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'create_datetime'); ?>
		<div class="controls">
		<?php echo $form->textField($model,'create_datetime'); ?>
		<?php echo $form->error($model,'create_datetime'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'update_datetime'); ?>
		<div class="controls">
		<?php echo $form->textField($model,'update_datetime'); ?>
		<?php echo $form->error($model,'update_datetime'); ?>
		</div>
	</div>

	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>
</div>