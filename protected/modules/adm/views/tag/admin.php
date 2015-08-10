<?php
/* @var $this TagController */
/* @var $model Tag */

$this->breadcrumbs=array(
	'Tags'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Tag', 'url'=>array('index')),
	array('label'=>'Create Tag', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tag-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Tags</h1>

<div class="search-form" style="">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<div class="row-fluid">
<div class="span12">
<div class="widget-box">
	<div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
	<h5>List</h5>
	<span style="float:right;padding:3px;"><a href="create" class="btn btn-info"><i class="icon-plus"></i>ADD</a></span>
	</div>
	<div class="widget-content nopadding">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tag-grid',
	'dataProvider'=>$model->search(),
	'summaryCssClass'=>'label label-info',
	'htmlOptions'=>array('class'=>'dataTables_wrapper'),
	'itemsCssClass'=>'table table-bordered data-table dataTable',
	'template'=>'{items}{summary}{pager}',
	'enableHistory'=>true,
	'pager'=>array('class'=>'CAdminCLinkPager'),
	//'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		array(
			'header'=>'Values',
			'value'=>'Tag::model()->getValues($data->values)',
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
</div>
</div>
</div>
</div>
