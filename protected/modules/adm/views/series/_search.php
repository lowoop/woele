<?php
/* @var $this SeriesController */
/* @var $model Series */
/* @var $form CActiveForm */
?>

<div class="widget-box">
   <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
      <h5>Search Form</h5>
   </div>
     <div class="widget-content nopadding">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'htmlOptions'=>array('class'=>'form-horizontal'),
	'method'=>'get',
)); ?>
<div class="control-group" style="padding:10px;">
	<span class="condition">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>128)); ?>
	</span>

	<span class="condition">
		<?php echo CHtml::submitButton('Search'); ?>
	</span>
</div>
<?php $this->endWidget(); ?>
</div>
</div><!-- search-form -->