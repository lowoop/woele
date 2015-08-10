<?php
/* @var $this CourierController */
/* @var $model Courier */

$this->breadcrumbs=array(
	'Couriers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Courier', 'url'=>array('index')),
	array('label'=>'Manage Courier', 'url'=>array('admin')),
);
?>

<h1>Create Courier</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>