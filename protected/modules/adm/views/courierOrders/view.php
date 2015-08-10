<?php
/* @var $this CourierOrdersController */
/* @var $model CourierOrders */

$this->breadcrumbs=array(
	'Courier Orders'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CourierOrders', 'url'=>array('index')),
	array('label'=>'Create CourierOrders', 'url'=>array('create')),
	array('label'=>'Update CourierOrders', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CourierOrders', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CourierOrders', 'url'=>array('admin')),
);
?>

<h1>View CourierOrders #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'oid',
		'cid',
		'status',
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
