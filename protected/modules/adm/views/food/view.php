<?php
/* @var $this FoodController */
/* @var $model Food */

$this->breadcrumbs=array(
	'Foods'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Food', 'url'=>array('index')),
	array('label'=>'Create Food', 'url'=>array('create')),
	array('label'=>'Update Food', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Food', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Food', 'url'=>array('admin')),
);
?>

<h1>View Food #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
        array(
            'name'=>'rid',
            'value'=>$model->restaurant->name,
        ),
        array(
            'name'=>'image',
            'type'=>'raw',
            'value'=>'<img style="width:100px;height:70px" src="/img/upload/'.$model->image.'">',
        ),
		'price',
        'discount',
        'rec',
        'sortnum',
		'desc',
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
