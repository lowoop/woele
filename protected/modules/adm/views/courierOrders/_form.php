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
          <h5>Series</h5>
        </div>
        <div class="widget-content nopadding">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'courier-orders-form',
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
		<?php echo $form->labelEx($model,'cid',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->dropDownList($model,'cid',$arr_courier); ?>
		<?php echo $form->error($model,'cid'); ?>
		</div>
	</div>

	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>
</div>