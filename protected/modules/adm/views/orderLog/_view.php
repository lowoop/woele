<?php
/* @var $this OrderLogController */
/* @var $data OrderLog */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oid')); ?>:</b>
	<?php echo CHtml::encode($data->oid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rid')); ?>:</b>
	<?php echo CHtml::encode($data->rid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('uid')); ?>:</b>
	<?php echo CHtml::encode($data->uid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('desc')); ?>:</b>
	<?php echo CHtml::encode($data->desc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_datetime')); ?>:</b>
	<?php echo CHtml::encode(date("Y-m-d H:i:s",$data->create_datetime)); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('update_datetime')); ?>:</b>
	<?php echo CHtml::encode($data->update_datetime); ?>
	<br />

	*/ ?>

</div>