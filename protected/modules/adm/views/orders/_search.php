<?php
/* @var $this OrdersController */
/* @var $model Order */
/* @var $form CActiveForm */
$rest = Restaurant::model()->findAll();
$arr_rest = array();
if($rest)
{
    foreach($rest as $value)
    {
        $arr_rest[$value->id] = $value->name;
    }
}
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
		<?php echo $form->textField($model,'id',array('class'=>'span2')); ?>
	</span>

    <span class="condition">
		<?php echo $form->label($model,'onum'); ?>
        <?php echo $form->textField($model,'onum',array('class'=>'span2')); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'rid'); ?>
		<?php echo $form->dropDownList($model,'rid',$arr_rest,array('prompt'=>'全部')); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'uid'); ?>
		<?php echo $form->textField($model,'uid'); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'realname'); ?>
		<?php echo $form->textField($model,'realname',array('class'=>'span2')); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'user_address'); ?>
		<?php echo $form->textField($model,'user_address',array('class'=>'span2')); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'user_mobile'); ?>
		<?php echo $form->textField($model,'user_mobile',array('class'=>'span2')); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'expect_date'); ?>
		<?php echo $form->textField($model,'expect_date',array('class'=>'span1')); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'expect_time'); ?>
		<?php echo $form->textField($model,'expect_time',array('class'=>'span2')); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'total_price'); ?>
		<?php echo $form->textField($model,'total_price[]',array('class'=>'span1')); ?> - <?php echo $form->textField($model,'total_price[]',array('class'=>'span1')); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'paytype'); ?>
		<?php echo $form->textField($model,'paytype',array('class'=>'span2')); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'payment'); ?>
		<?php echo $form->dropDownList($model,'payment',Order::getPayment(),array('class'=>'span2','prompt'=>'全部')); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Order::getStatus(),array('class'=>'span2','prompt'=>'全部')); ?>
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