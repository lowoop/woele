<?php
/* @var $this SeriesController */
/* @var $model Series */

$this->breadcrumbs=array(
	'Series'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Series', 'url'=>array('index')),
	array('label'=>'Create Series', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#series-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Series</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<div class="row-fluid">
<div class="span12">
<div class="widget-box">
	<div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
	<h5>List</h5>
	<span style="float:right;padding:3px;"><a href="<?php echo Yii::app()->createUrl("/adm/series/create");?>" class="btn btn-info"><i class="icon-plus"></i>ADD</a></span>
	</div>
	<div class="widget-content nopadding">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'series-grid',
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
			'class'=>'CButtonColumn',
		),
	),
)); ?>
</div>
</div>
</div>
</div>
