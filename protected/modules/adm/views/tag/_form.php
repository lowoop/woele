<?php
/* @var $this TagController */
/* @var $model Tag */
/* @var $form CActiveForm */
//print_r($model->values);
?>

<div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Series</h5>
        </div>
        <div class="widget-content nopadding">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tag-form',
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
		<?php echo $form->labelEx($model,'name',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'name'); ?>
		</div>
	</div>
	
	<div class="control-group">
		<?php echo CHtml::label('name',false,array('class'=>'control-label')); ?>
		<div class="controls">
		<div id="single_attr_values">
		<?php foreach ($model->values as $v){?>
		<input name="values[]" type="text" vid="<?php echo $v->id;?>" class="span1 new_val" value="<?php echo $v->value;?>">
		<?php }?>
		<input name="values[]" type="text" vid="0" class="span1 new_val" onfocus="add_single(this)">
		</div>
		</div>
	</div>
	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>
</div>
<script>
function add_single(obj)
{
	$("#single_attr_values").append('&nbsp;<input name="values[]" type="text" vid="0" class="span1 new_val" onfocus="add_single(this)">');
	obj.onfocus="";
}
$("#tag-form").submit(function(e){
	$(".new_val").each(function(i){
		var vvv = $(this).attr("vid")+":"+$(this).val();
		$(this).val(vvv);
	});
// 	e.preventDefault();
//     alert("Submit prevented");
//     $(this).submit();
  });
</script>