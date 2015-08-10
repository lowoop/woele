<?php
/* @var $this OrdersController */
/* @var $data Order */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rid')); ?>:</b>
	<?php echo CHtml::encode($data->rid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('uid')); ?>:</b>
	<?php echo CHtml::encode($data->uid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('realname')); ?>:</b>
	<?php echo CHtml::encode($data->realname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_address')); ?>:</b>
	<?php echo CHtml::encode($data->user_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_mobile')); ?>:</b>
	<?php echo CHtml::encode($data->user_mobile); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('expect_date')); ?>:</b>
	<?php echo CHtml::encode($data->expect_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('expect_time')); ?>:</b>
	<?php echo CHtml::encode($data->expect_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_price')); ?>:</b>
	<?php echo CHtml::encode($data->total_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('paytype')); ?>:</b>
	<?php echo CHtml::encode($data->paytype); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment')); ?>:</b>
	<?php echo CHtml::encode($data->payment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cardnum')); ?>:</b>
	<?php echo CHtml::encode($data->cardnum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cardowner')); ?>:</b>
	<?php echo CHtml::encode($data->cardowner); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('food_datetime')); ?>:</b>
	<?php echo CHtml::encode($data->food_datetime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('send_datetime')); ?>:</b>
	<?php echo CHtml::encode($data->send_datetime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('finish_datetime')); ?>:</b>
	<?php echo CHtml::encode($data->finish_datetime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_datetime')); ?>:</b>
	<?php echo CHtml::encode($data->create_datetime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_datetime')); ?>:</b>
	<?php echo CHtml::encode($data->update_datetime); ?>
	<br />

	*/ ?>

</div>