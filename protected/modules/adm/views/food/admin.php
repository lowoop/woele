<?php
/* @var $this FoodController */
/* @var $model Food */

$this->breadcrumbs=array(
	'Foods'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Food', 'url'=>array('index')),
	array('label'=>'Create Food', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#food-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="search-form" >
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<div class="row-fluid">
<div class="span12">
<div class="widget-box">
	<div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
	<h5> List</h5>
	<span style="float:right;padding:3px;"><a href="<?php echo Yii::app()->createUrl("/adm/food/create")?>" class="btn btn-info"><i class="icon-plus"></i>ADD</a></span>
	</div>
	<div class="widget-content nopadding">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'food-grid',
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
		'type',
        array(
            'name'=>'rid',
            'type'=>'raw',
            'value'=>'$data->restaurant->name',
        ),
		array(
			'name'=>'image',
			'type'=>'raw',
			'value'=>'"<img style=\"width:100px;height:70px\" src=\"/img/upload/$data->image\">"',
		),
		'price',
        array(
            'name'=>'rec',
            'type'=>'raw',
            'value'=>'"<span style=\'".($data->rec==1?"color:red":"")."\'>".JConfig::item("config.rec.".$data->rec)."</span>"',
        ),
        'sortnum',
        'discount',
		'desc',
        array(
            'name'=>'create_datetime',
            'value'=>'date("Y-m-d H:i:s",$data->create_datetime)',
        ),
        array(
            'name'=>'status',
            'value'=>'Food::getStatus($data->status)',
        ),
		/*

		
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
