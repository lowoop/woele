<?php
/* @var $this FoodController */
/* @var $model Food */

$this->breadcrumbs=array(
	'Foods'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Food', 'url'=>array('index')),
	array('label'=>'Manage Food', 'url'=>array('admin')),
);
?>

<h1>Create Food</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>