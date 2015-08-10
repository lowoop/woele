<?php
/* @var $this OrderLogController */
/* @var $model OrderLog */

$this->breadcrumbs=array(
	'Order Logs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OrderLog', 'url'=>array('index')),
	array('label'=>'Create OrderLog', 'url'=>array('create')),
	array('label'=>'View OrderLog', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OrderLog', 'url'=>array('admin')),
);
?>

<h1>Update OrderLog <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>