<?php
/* @var $this OrdersController */
/* @var $model Order */

$this->breadcrumbs=array(
	'Orders'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Order', 'url'=>array('index')),
	array('label'=>'Create Order', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#order-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
$courier = Courier::model()->findAll("status = :status",array('status'=>Courier::STATUS_NORMAL));
$arr_courier = array();
foreach($courier as $key=>$value)
{
    $arr_courier[$value->id] = $value->name;
}
?>
<div class="widget-box">
	  <div class="widget-title">
	     <ul class="nav nav-tabs">
             <?php
                $active = "";
                if(isset($_GET['t']))
                {
                    $active = $_GET['t'];
                }
             ?>
	       <li class="<?php echo $active==""?"active":"";?>"><a href="<?php echo Yii::app()->createUrl("/adm/orders/admin");?>">全部订单</a></li>
	       <li class="<?php echo $active==='0'?"active":"";?>"><a href="<?php echo Yii::app()->createUrl("/adm/orders/admin")."?t=0";?>">待处理订单</a></li>
	       <li class="<?php echo $active==='1'?"active":"";?>"><a href="<?php echo Yii::app()->createUrl("/adm/orders/admin")."?t=1";?>">已处理订单</a></li>
	       <li class="<?php echo $active==='2'?"active":"";?>"><a href="<?php echo Yii::app()->createUrl("/adm/orders/admin")."?t=2";?>">已完成订单</a></li>
	     </ul>
	  </div>
	<div class="widget-content tab-content">
	<div id="tab1" class="tab-pane active">
           
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
			'id'=>'order-grid',
			'dataProvider'=>$model->search($criteria),
			'summaryCssClass'=>'label label-info',
			'htmlOptions'=>array('class'=>'dataTables_wrapper'),
			'itemsCssClass'=>'table table-bordered data-table dataTable',
			'template'=>'{items}{summary}{pager}',
			'enableHistory'=>true,
			'pager'=>array('class'=>'CAdminCLinkPager'),
			'rowHtmlOptionsExpression'=>"array('data-id'=>\$data->id,'data-status'=>\$data->status)",
			//'filter'=>$model,
			'columns'=>array(
				'id',
                'onum',
				array(
					'name'=>'rid',
					'type'=>'raw',
					'htmlOptions'=>array('style'=>'text-align:left;'),
					'value'=>'$data->restaurant?"名称:".$data->restaurant->name."<br>地址:".$data->restaurant->address."<br>电话:".$data->restaurant->tel."<br>手机:".$data->restaurant->mobile."<br>送餐区号:".trim($data->restaurant->area,","):""',
				),
				array(
					'name'=>'uid',
					'value'=>'$data->user?$data->user->username:""',
				),
				array(
						'name'=>'realname',
						'header'=>'姓名/地址/电话',
						'type'=>'raw',
						'value'=>'$data->realname."<br>(".$data->user_address.")"."<br>(".$data->user_mobile.")"',
				),
				array(
					'header'=>"送餐时间",
					'value'=>'$data->expect_date.":".$data->expect_time',
				),
				array(
					'name'=>'total_price',
					'header'=>'总价/菜单',
					'type'=>'raw',
					'value'=>'"$".floatval($data->total_price)."<br>".$data->getFoodList()',
					//'htmlOptions'=>array(),
				),
//				'paytype',
				array(
					'name'=>'payment',
					'type'=>'raw',
					'value'=>'"(".$data->paytype.")<br>".Order::model()->getPayment($data->payment)',
				),
                array(
                    'name'=>'courier',
                    'type'=>'raw',
                    'value'=>'$data->cour?$data->cour->name."<br>(".$data->cour->mobile.")":""',
                ),
				array(
					'name'=>'status',
					'value'=>'Order::model()->getStatus($data->status)',
				),

                array(
                    'name'=>'food_datetime',
                    'value'=>'date("Y-m-d H:i:s",$data->food_datetime)',
                ),
                array(
                    'name'=>'send_datetime',
                    'value'=>'date("Y-m-d H:i:s",$data->send_datetime)',
                ),
                array(
                    'name'=>'create_datetime',
                    'value'=>'date("Y-m-d H:i:s",$data->create_datetime)',
                ),
				/*
				'cardnum',
				'cardowner',
				'update_datetime',
				*/
				array(
					'class'=>'CButtonColumn',
					'template'=>'{view} {delete} {rec}',
					'buttons'=>array(
                        'delete'=>array(
                            'visible'=>'$data->status!=Order::STATUS_COMPLETE&&$data->status!=Order::STATUS_DELETE&&$data->status!=Order::STATUS_CLOSED',
                        ),
						'rec'=>array(
								'label'=>'处理',
								'options'=>array('class'=>'btn btn-mini btn-primary btn-rec','data-toggle'=>'modal'),
								'url'=>'"#rec_div"',
								'visible'=>'$data->status!=Order::STATUS_COMPLETE&&$data->status!=Order::STATUS_DELETE&&$data->status!=Order::STATUS_CLOSED',
						),
					),
				),
			),
		)); ?>
		</div>
		</div>
		</div>
		</div>
	</div>
	</div>
</div>
<div class="modal fade" id="rec_div" data-id="" data-status="">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
               	 处理订单
            </h4>
         </div>
         <div class="modal-body">
	          <div class="form-horizontal">
	            <div class="control-group">
	              <label class="control-label">设置状态:</label>
	              <div class="controls">
	                <?php echo CHtml::dropDownList("status", "", Order::getStatus(),array("id"=>"rec_status"))?>
	              </div>
	            </div>
	            <div id="cour" style="display:none;">
	            	<div class="control-group">
		              <label class="control-label">送达时间:</label>
		              <div class="controls">
		                <div data-date="" class="input-append date datepicker" >
						<?php echo CHtml::textField('send_datetime','',array('id'=>'send_datetime','class'=>"span2", 'data-format'=>'yyyy-MM-dd hh:mm:ss')); ?>
						<span class="add-on"><i class="icon-th"></i></span>
						</div>
		              </div>
		            </div>
		            <div class="control-group">
		              <label class="control-label">配送人:</label>
		              <div class="controls">
		                <?php echo CHtml::dropDownList("courier","",$arr_courier,array("id"=>"courier"));?>
		              </div>
		            </div>
		            <div class="control-group" style="display: none">
		              <label class="control-label">配送人电话:</label>
		              <div class="controls">
		                <?php echo CHtml::textField("courier_mobile","",array("id"=>"courier_mobile"));?>
		              </div>
		            </div>
	            </div>
	            <div class="control-group">
	              <label class="control-label">备注:</label>
	              <div class="controls">
	                <?php echo CHtml::textArea("desc","",array("id"=>"desc"));?>
	              </div>
	            </div>
	          </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭 </button>
            <button type="button" class="btn btn-primary" id="ok_btn">确定</button>
         </div>
      </div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>
<script>
$(".btn-rec").live('click',function(){
	var id = $(this).parents('tr').attr('data-id');
	var status = $(this).parents('tr').attr('data-status');
	$("#rec_div").attr('data-id',id);
	$("#rec_div").attr('data-status',status);
	$("#courier").val("");
	$("#courier_mobile").val("");
});
$("#rec_status").change(function(){
	if($(this).val()==4)
	{
		$("#cour").show();
	}
	else
	{
		$("#courier").val("");
		$("#courier_mobile").val("");
		$("#cour").hide();
	}
});
$("#ok_btn").live('click',function(){
	var id = $("#rec_div").attr('data-id');
	var status = $("#rec_status").val();
	var courier = $("#courier").val();
	var courier_mobile = $("#courier_mobile").val();
	var desc = $("#desc").val();
	var send_datetime = $("#send_datetime").val();
	$.ajax({
		type:'post',
		url: '<?php echo Yii::app()->createUrl("/adm/orders/conf")?>',
		dataType: 'json',
			data:{id:id,status:status,courier:courier,courier_mobile:courier_mobile,desc:desc,send_datetime:send_datetime},
			success: function(data){
				if(data.status=='success') {
					$('#order-grid').yiiGridView('update');
					$('#rec_div').modal('hide');
				} else {
					alert(data.msg);
				}
			}
	});
});
$(function(){

});
</script>