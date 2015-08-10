<?php
/* @var $this CourierController */
/* @var $model Courier */

$this->breadcrumbs=array(
	'Couriers'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Courier', 'url'=>array('index')),
	array('label'=>'Create Courier', 'url'=>array('create')),
	array('label'=>'Update Courier', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Courier', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Courier', 'url'=>array('admin')),
);
?>

<h1>View Courier #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
        array(
            'name'=>'image',
            'type'=>'raw',
            'value'=>'<img style="width:100px;height:70px" src="/img/upload/'.$model->image.'">',
        ),
		'mobile',
		'moto',
		'email',
		array(
            'name'=>'status',
            'value'=>Courier::getStatus($model->status),
        ),
        array(
            'label'=>'create_datetime',
            'value'=>date('Y-m-d H:i:s',$model->create_datetime),
        ),
	),
)); ?>
