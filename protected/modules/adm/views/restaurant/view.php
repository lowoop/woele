<?php
/* @var $this RestaurantController */
/* @var $model Restaurant */

$this->breadcrumbs=array(
	'Restaurants'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Restaurant', 'url'=>array('index')),
	array('label'=>'Create Restaurant', 'url'=>array('create')),
	array('label'=>'Update Restaurant', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Restaurant', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Restaurant', 'url'=>array('admin')),
);
?>

<h1>View Restaurant #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'uid',
		'name',
		'image',
		'tel',
		'mobile',
		'address',
		'open_time',
		'close_time',
		array(
			'name'=>'area',
			'value'=>trim($model->area,","),
		),
		'zipcode',
		array(
				'name'=>'vip',
				'value'=>JConfig::item("config.vip.".$model->vip),
		),
		'sortnum',
		array(
			'name'=>'status',
			'value'=>Restaurant::getStatus($model->status),
		),
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
