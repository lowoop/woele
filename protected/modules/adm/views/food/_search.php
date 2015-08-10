<?php
/* @var $this FoodController */
/* @var $model Food */
/* @var $form CActiveForm */
$restaurant = Restaurant::model()->findAll();
$arr_rest = array();
foreach($restaurant as $value)
{
    $arr_rest[$value->id] = $value->name;
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
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</span>

    <span class="condition">
		<?php echo $form->label($model,'rid'); ?>
        <?php echo $form->dropDownList($model,'rid',$arr_rest,array('prompt'=>'全部')); ?>
	</span>

    <span class="condition">
		<?php echo $form->label($model,'type'); ?>
        <?php echo $form->textField($model,'type'); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'price'); ?>
		<?php echo $form->textField($model,'price[]',array('class'=>'span1')); ?>
        -
		<?php echo $form->textField($model,'price[]',array('class'=>'span1')); ?>
	</span>

	<span class="condition">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Food::getStatus(),array('class'=>'span1','prompt'=>'全部')); ?>
	</span>

    <span class="condition">
		<?php echo $form->label($model,'rec'); ?>
        <?php echo $form->dropDownList($model,'rec',JConfig::item("config.rec"),array('class'=>'span1','prompt'=>'全部')); ?>
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