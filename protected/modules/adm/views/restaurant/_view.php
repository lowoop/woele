<?php
/* @var $this RestaurantController */
/* @var $data Restaurant */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('uid')); ?>:</b>
	<?php echo CHtml::encode($data->uid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('image')); ?>:</b>
	<?php echo CHtml::encode($data->image); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tel')); ?>:</b>
	<?php echo CHtml::encode($data->tel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mobile')); ?>:</b>
	<?php echo CHtml::encode($data->mobile); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($data->address); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('open_time')); ?>:</b>
	<?php echo CHtml::encode($data->open_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('close_time')); ?>:</b>
	<?php echo CHtml::encode($data->close_time); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('area')); ?>:</b>
	<?php echo CHtml::encode($data->close_time); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('zipcode')); ?>:</b>
	<?php echo CHtml::encode($data->close_time); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('create_datetime')); ?>:</b>
	<?php echo CHtml::encode(date("Y-m-d H:i:s",$data->create_datetime)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_datetime')); ?>:</b>
	<?php echo CHtml::encode(date("Y-m-d H:i:s",$data->update_datetime)); ?>
	<br />
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('map_x')); ?>:</b>
	<?php echo CHtml::encode($data->map_x); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('map_y')); ?>:</b>
	<?php echo CHtml::encode($data->map_y); ?>
	<br />

	

	

	*/ ?>

</div>