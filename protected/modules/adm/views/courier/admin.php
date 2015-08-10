<?php
/* @var $this CourierController */
/* @var $model Courier */

$this->breadcrumbs=array(
	'Couriers'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Courier', 'url'=>array('index')),
	array('label'=>'Create Courier', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#courier-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

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
	'id'=>'courier-grid',
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
            'name'=>'image',
            'type'=>'raw',
            'value'=>'"<img style=\"width:100px;height:70px\" src=\"/img/upload/$data->image\">"',
        ),
		'mobile',
		'moto',
		'email',
        array(
            'name'=>'status',
            'value'=>'Courier::getStatus($data->status)',
        ),
        array(
            'name'=>'isbusy',
            'value'=>'Courier::model()->getWorkStatus($data->isbusy)',
        ),
        array(
            'name'=>'create_datetime',
            'value'=>'date("Y-m-d H:i:s",$data->create_datetime)',
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
