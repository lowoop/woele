<?php
/* @var $this AdminController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<h1>View User #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'password',
		'email',
		'role',
		'tel',
		'mobile',
		'address_id',
		'source',
		array(
			'label'=>'address',
			'type'=>'raw',
			'value'=>Address::getAddressString($model->address,$model->address_id),
		),
		'uuid',
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
