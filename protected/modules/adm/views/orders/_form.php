<?php
/* @var $this OrdersController */
/* @var $model Order */
/* @var $form CActiveForm */
?>

<div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Series</h5>
        </div>
        <div class="widget-content nopadding">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-form',
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
		<?php echo $form->labelEx($model,'rid',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'rid'); ?>
		<?php echo $form->error($model,'rid'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'uid',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'uid'); ?>
		<?php echo $form->error($model,'uid'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'realname',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'realname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'realname'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'user_address',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'user_address',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'user_address'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'user_mobile',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'user_mobile',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'user_mobile'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'expect_date',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'expect_date',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'expect_date'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'expect_time',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'expect_time',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'expect_time'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'total_price',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'total_price'); ?>
		<?php echo $form->error($model,'total_price'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'paytype',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'paytype',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'paytype'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'payment',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'payment',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'payment'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'cardnum',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'cardnum',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'cardnum'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'cardowner',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'cardowner',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'cardowner'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'status',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'food_datetime',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'food_datetime'); ?>
		<?php echo $form->error($model,'food_datetime'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'send_datetime',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'send_datetime'); ?>
		<?php echo $form->error($model,'send_datetime'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'finish_datetime',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'finish_datetime'); ?>
		<?php echo $form->error($model,'finish_datetime'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'create_datetime',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'create_datetime'); ?>
		<?php echo $form->error($model,'create_datetime'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'update_datetime',array('class'=>'control-label')); ?>
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