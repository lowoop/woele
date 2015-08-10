<?php
/* @var $this CourierOrdersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Courier Orders',
);

$this->menu=array(
	array('label'=>'Create CourierOrders', 'url'=>array('create')),
	array('label'=>'Manage CourierOrders', 'url'=>array('admin')),
);
?>

<h1>Courier Orders</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
