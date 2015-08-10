<?php
/* @var $this OrdersController */
/* @var $model Order */

$this->breadcrumbs=array(
	'Orders'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Order', 'url'=>array('index')),
	array('label'=>'Create Order', 'url'=>array('create')),
	array('label'=>'Update Order', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Order', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Order', 'url'=>array('admin')),
);
?>

<h1>查看订单 #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'name'=>'rid',
			'type'=>'raw',
			'value'=>$model->restaurant?"名称:".$model->restaurant->name."<br>地址:".$model->restaurant->address."<br>电话:".$model->restaurant->tel."<br>手机:".$model->restaurant->mobile."<br>送餐区号:".trim($model->restaurant->area,","):"",
		),
		array(
			'label'=>'用户信息',
			'type'=>'raw',
			'value'=>"姓名:".$model->realname."<br>地址:".$model->user_address."<br>电话:".$model->user_mobile,
		),
		'expect_date',
		'expect_time',
		array(
			'label'=>'总价/菜单',
			'type'=>'raw',
			'value'=>"总价:$".floatval($model->total_price)."<br>".$model->getFoodList(),
		),
		'paytype',
		array(
			'name'=>'payment',
			'value'=>Order::getPayment($model->payment),
		),
		'cardnum',
		'cardowner',
		array(
			'name'=>'status',
			'value'=>Order::getStatus($model->status),
		),
		'desc',
        array(
            'label'=>'food_datetime',
            'value'=>date('Y-m-d H:i:s',$model->food_datetime),
        ),
        array(
            'label'=>'send_datetime',
            'value'=>date('Y-m-d H:i:s',$model->send_datetime),
        ),
        array(
            'label'=>'finish_datetime',
            'value'=>date('Y-m-d H:i:s',$model->finish_datetime),
        ),
        array(
            'label'=>'create_datetime',
            'value'=>date('Y-m-d H:i:s',$model->create_datetime),
        ),
        array(
            'label'=>'update_datetime',
            'value'=>date('Y-m-d H:i:s',$model->update_datetime),
        ),
	),
)); ?>
