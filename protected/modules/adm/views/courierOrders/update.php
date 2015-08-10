<?php
/* @var $this CourierOrdersController */
/* @var $model CourierOrders */

$this->breadcrumbs=array(
	'Courier Orders'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CourierOrders', 'url'=>array('index')),
	array('label'=>'Create CourierOrders', 'url'=>array('create')),
	array('label'=>'View CourierOrders', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CourierOrders', 'url'=>array('admin')),
);
?>

<h1>Update CourierOrders <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>