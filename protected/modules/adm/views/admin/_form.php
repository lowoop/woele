<?php
/* @var $this AdminController */
/* @var $model User */
/* @var $form CActiveForm */
?>
<div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Accounts</h5>
        </div>
        <div class="widget-content nopadding">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
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
		<?php echo $form->labelEx($model,'username',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'username'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'password',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'password'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'email',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
		</div>
	</div>

	<?php if($model->username!=="admin"){?>
	<div class="control-group">
		<?php echo $form->labelEx($model,'role',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->dropDownList($model,'role',JConfig::item('config.role'),array('prompt'=>'全部')); ?>
		<?php echo $form->error($model,'role'); ?>
		</div>
	</div>
	<?php }?>

	<div class="control-group">
		<?php echo $form->labelEx($model,'tel',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'tel',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'tel'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'mobile',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'mobile',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'mobile'); ?>
		</div>
	</div>

	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
</div>