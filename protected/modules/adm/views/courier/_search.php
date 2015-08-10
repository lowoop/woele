<?php
/* @var $this CourierController */
/* @var $model Courier */
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
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'mobile'); ?>
		<?php echo $form->textField($model,'mobile',array('size'=>10,'maxlength'=>10)); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'moto'); ?>
		<?php echo $form->textField($model,'moto',array('size'=>60,'maxlength'=>100)); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Courier::getStatus(),array('prompt'=>'全部')); ?>
	</span>

    <span class="condition">
		<?php echo $form->label($model,'isbusy'); ?>
        <?php echo $form->dropDownList($model,'status',Courier::getWorkStatus(),array('prompt'=>'全部')); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'create_datetime'); ?>
		<?php echo $form->textField($model,'create_datetime'); ?>
	</span>

	<span class="condition">
		<?php echo CHtml::submitButton('Search'); ?>
	</span>
</div>
<?php $this->endWidget(); ?>
</div>
</div><!-- search-form -->