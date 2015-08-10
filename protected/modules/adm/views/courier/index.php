<?php
/* @var $this CourierController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Couriers',
);

$this->menu=array(
	array('label'=>'Create Courier', 'url'=>array('create')),
	array('label'=>'Manage Courier', 'url'=>array('admin')),
);
?>

<h1>Couriers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
