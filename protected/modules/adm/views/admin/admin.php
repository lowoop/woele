<?php
/* @var $this AdminController */
/* @var $model User */

$this->breadcrumbs=array(
	'Accounts'=>array('admin'),
	'List',
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
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
	<h5>Account List</h5>
	<span style="float:right;padding:3px;"><a href="<?php echo Yii::app()->createUrl("/adm/admin/create");?>" class="btn btn-info"><i class="icon-plus"></i>ADD</a></span>
	</div>
	<div class="widget-content nopadding">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
		'summaryCssClass'=>'label label-info',
		'htmlOptions'=>array('class'=>'dataTables_wrapper'),
		'itemsCssClass'=>'table table-bordered data-table dataTable',
		'template'=>"{items}{summary}{pager}",
		'enableHistory'=>true,
		'pager'=>array('class'=>'CAdminCLinkPager'),
		'pagerCssClass'=>'paginate',
// 		'baseScriptUrl'=>'public/gridview',
// 	'filter'=>$model,
	'columns'=>array(
		'id',
		'role',
		'username',
		'realname',
		'email',
		
		'mobile',
		array(
			'header'=>'address',
			'type'=>'raw',
			'value'=>'Address::getAddressString($data->address,$data->address_id)',
			'htmlOptions'=>array('style'=>'text-align:left'),
		),
		'source',
		array(
			'name'=>'status',
			'value'=>'User::model()->getStatus($data->status)',
		),
        array(
            'name'=>'create_datetime',
            'value'=>'date("Y-m-d H:i:s",$data->create_datetime)',
        ),
		/*
		'address_id',
		'uuid',
		
		'update_datetime',
		*/
		array(
			'class'=>'CButtonColumn',
			'afterDelete'=>'function(link,success,data){if(data!="") alert(data);}',
			'buttons'=>array(
				'delete'=>array(
						'visible'=>'$data->username!="admin"',
				),
			),
		),
	),
)); 

?>
</div>
</div>
</div>
</div>
