<?php
/* @var $this CourierController */
/* @var $model Courier */

$this->breadcrumbs=array(
	'Couriers'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Courier', 'url'=>array('index')),
	array('label'=>'Create Courier', 'url'=>array('create')),
	array('label'=>'View Courier', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Courier', 'url'=>array('admin')),
);
?>

<h1>Update Courier <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>