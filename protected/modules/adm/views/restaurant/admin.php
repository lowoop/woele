<?php
/* @var $this RestaurantController */
/* @var $model Restaurant */

$this->breadcrumbs=array(
	'Restaurants'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Restaurant', 'url'=>array('index')),
	array('label'=>'Create Restaurant', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#restaurant-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<div class="row-fluid">
<div class="span12">
<div class="widget-box">
	<div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
	<h5>Restaurants List</h5>
	<span style="float:right;padding:3px;"><a href="<?php echo Yii::app()->createUrl("/adm/Restaurant/create");?>" class="btn btn-info"><i class="icon-plus"></i>ADD</a></span>
	</div>
	<div class="widget-content nopadding">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'restaurant-grid',
		'summaryCssClass'=>'label label-info',
		'htmlOptions'=>array('class'=>'dataTables_wrapper'),
		'itemsCssClass'=>'table table-bordered data-table dataTable',
		'template'=>"{items}{summary}{pager}",
		'enableHistory'=>true,
		'pager'=>array('class'=>'CAdminCLinkPager'),
	'dataProvider'=>$model->search(),
// 	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
			'name'=>'uid',
			'value'=>'$data->user?$data->user->username:""',
		),
		'name',
		array(
			'name'=>'image',
			'type'=>'raw',
			'value'=>'"<img style=\"width:100px;height:70px\" src=\"/img/upload/$data->image\">"',
		),
		'tel',
		'address',
		array(
			'name'=>'area',
			'value'=>'trim($data->area,",")',
		),
		array(
			'name'=>'vip',
			'type'=>'raw',
			'value'=>'"<span style=\'".($data->vip==1?"color:red":"")."\'>".JConfig::item("config.vip.".$data->vip)."</span>"',
		),
		'sortnum',
		'open_time',
		'close_time',
		array(
			'name'=>'status',
			'value'=>'Restaurant::getStatus($data->status)',
		),
		array(
            'name'=>'create_datetime',
            'value'=>'date("Y-m-d H:i:s",$data->create_datetime)',
        ),
		/*
		'mobile',
		
		'map_x',
		'map_y',
		'open_time',
		'close_time',
		
		
		'update_datetime',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
</div>
</div>
</div>
</div>