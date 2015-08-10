<?php
/* @var $this OrderLogController */
/* @var $model OrderLog */

$this->breadcrumbs=array(
	'Order Logs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List OrderLog', 'url'=>array('index')),
	array('label'=>'Create OrderLog', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#order-log-grid').yiiGridView('update', {
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
	</div>
	<div class="widget-content nopadding">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'order-log-grid',
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
		'oid',
        array(
            'header'=>'订单号',
            'value'=>'$data->order?$data->order->onum:""',
        ),
		array(
            'name'=>'rid',
            'value'=>'$data->restaurant?$data->restaurant->name:$data->rid',
        ),
        array(
            'name'=>'uid',
            'value'=>'$data->user?$data->user->username:$data->uid',
        ),
        array(
            'name'=>'status',
            'value'=>'Order::getStatus($data->status)',
        ),
		'desc',
        array(
            'name'=>'create_datetime',
            'value'=>'date("Y-m-d H:i:s",$data->create_datetime)',
        ),
		/*

		'update_datetime',
		*/
		/*array(
			'class'=>'CButtonColumn',
		),*/
	),
)); ?>
</div>
</div>
</div>
</div>
