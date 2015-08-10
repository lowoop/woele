<?php
/* @var $this CourierOrdersController */
/* @var $model CourierOrders */

$this->breadcrumbs=array(
	'Courier Orders'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CourierOrders', 'url'=>array('index')),
	array('label'=>'Manage CourierOrders', 'url'=>array('admin')),
);
?>

<h1>Create CourierOrders</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>