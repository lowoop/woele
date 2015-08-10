<?php
/* @var $this AdminController */
/* @var $model User */
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
				<?php echo $form->label($model,'username'); ?>
				<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>128)); ?>
			</span>
		
			<span class="condition">
				<?php echo $form->label($model,'email'); ?>
				<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
			</span>
		
			<span class="condition">
				<?php echo $form->label($model,'role'); ?>
				<?php echo $form->textField($model,'role',array('size'=>20,'maxlength'=>20)); ?>
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
				<?php echo $form->label($model,'address_id'); ?>
				<?php echo $form->textField($model,'address_id'); ?>
			</span>
		
			<span class="condition">
				<?php echo $form->label($model,'uuid'); ?>
				<?php echo $form->textField($model,'uuid',array('size'=>60,'maxlength'=>128)); ?>
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
</div>