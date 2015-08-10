<?php
/* @var $this CourierOrdersController */
/* @var $model CourierOrders */

$this->breadcrumbs=array(
	'Courier Orders'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List CourierOrders', 'url'=>array('index')),
	array('label'=>'Create CourierOrders', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#courier-orders-grid').yiiGridView('update', {
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
	'id'=>'courier-orders-grid',
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
		array(
            'name'=>'oid',
//            'value'=>'$data->order->'
        ),
        array(
            'header'=>'订单号',
            'value'=>'$data->order?$data->order->onum:""'
        ),
        array(
            'name'=>'cid',
            'value'=>'$data->courier->name',
        ),
		array(
            'name'=>'status',
            'value'=>'CourierOrders::getStatus($data->status)',
        ),
        array(
            'header'=>'预计送达时间',
            'value'=>'date("Y-m-d H:i:s",$data->order->send_datetime)',
        ),
        array(
            'name'=>'create_datetime',
            'value'=>'date("Y-m-d H:i:s",$data->create_datetime)',
        ),
        array(
            'name'=>'update_datetime',
            'value'=>'date("Y-m-d H:i:s",$data->update_datetime)',
        ),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update}',
            'buttons'=>array(
                'update'=>array(
                    'visible'=>'$data->status==CourierOrders::STATUS_TRANS',
                ),
            ),
		),
	),
)); ?>
</div>
</div>
</div>
</div>
