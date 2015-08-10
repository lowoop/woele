<?php
/* @var $this OrderLogController */
/* @var $model OrderLog */

$this->breadcrumbs=array(
	'Order Logs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List OrderLog', 'url'=>array('index')),
	array('label'=>'Create OrderLog', 'url'=>array('create')),
	array('label'=>'Update OrderLog', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete OrderLog', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OrderLog', 'url'=>array('admin')),
);
?>

<h1>View OrderLog #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'oid',
		'rid',
		'uid',
		'status',
		'desc',
        array(
            'label'=>'create_datetime',
            'value'=>date('Y-m-d H:i:s',$model->create_datetime),
        ),
        array(
            'label'=>'update_datetime',
            'value'=>date('Y-m-d H:i:s',$model->update_datetime),
        ),
	),
)); ?>
