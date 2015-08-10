<?php
/* @var $this RestaurantController */
/* @var $model Restaurant */
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
		<?php echo $form->label($model,'uid'); ?>
		<?php echo $form->textField($model,'uid'); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>200)); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'tel'); ?>
		<?php echo $form->textField($model,'tel',array('size'=>20,'maxlength'=>20)); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'mobile'); ?>
		<?php echo $form->textField($model,'mobile',array('size'=>20,'maxlength'=>20)); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>200)); ?>
	</span>

    <span class="condition">
		<?php echo $form->label($model,'area'); ?>
        <?php echo $form->textField($model,'area'); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'open_time'); ?>
		<?php echo $form->textField($model,'open_time'); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'close_time'); ?>
		<?php echo $form->textField($model,'close_time'); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Restaurant::getStatus(),array('prompt'=>'全部')); ?>
	</span>

	<span class="condition">
				<?php echo $form->label($model,'create_datetime'); ?>
				<div data-date="" class="input-append date datepicker" >
				<?php echo $form->textField($model,'create_datetime[]',array('class'=>"span2", 'data-format'=>'yyyy-MM-dd hh:mm:ss')); ?>
					<span class="add-on"><i class="icon-th"></i></span>
				</div>
				-
				<div data-date="" class="input-append date datepicker" >
				<?php echo $form->textField($model,'create_datetime[]',array('class'=>"span2", 'data-format'=>'yyyy-MM-dd hh:mm:ss')); ?>
					<span class="add-on"><i class="icon-th"></i></span>
				</div>
	</span>
	<span class="condition">
		<?php echo CHtml::submitButton('Search'); ?>
	</span>
</div>
<?php $this->endWidget(); ?>

</div>
</div><!-- search-form -->