<?php
/* @var $this CourierOrdersController */
/* @var $model CourierOrders */
/* @var $form CActiveForm */
$courier = Courier::model()->findAll();
$arr_courier = array();
foreach($courier as $key=>$value)
{
    $arr_courier[$value->id] = $value->name."(".Courier::getStatus($value->status).")";
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
		<?php echo $form->textField($model,'id',array('class'=>'span1')); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'oid'); ?>
		<?php echo $form->textField($model,'oid',array('class'=>'span1')); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'cid'); ?>
		<?php echo $form->dropDownList($model,'cid',$arr_courier,array('prompt'=>'全部')); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',CourierOrders::getStatus(),array('class'=>'span2','prompt'=>'全部')); ?>
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