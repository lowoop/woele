<?php
/* @var $this RestaurantController */
/* @var $model Restaurant */
/* @var $form CActiveForm */
$users = User::model()->findAllByAttributes(array('role'=>'shop','status'=>'1'));
$arr_users = array();
if($users)
{
	foreach ($users as $value)
	{
		$arr_users[$value->id] = $value->username;
	}
}
$series = array();
$se = Series::model()->findAll();
if($se)
{
	foreach ($se as $value)
	{
		$series[$value->id] = $value->name;
	}
}
$sel_series = array();
if($model->series)
{
	foreach ($model->series as $value)
	{
		$sel_series[] = $value->sid;
	}
}
$tags = Tag::model()->findAll();
$arr_tags = array();
foreach ($tags as $value)
{
	$arr_tags[$value->id] = $value->name;
}
$model_tags = Restaurant::model()->getTags($model->tags);
?>
<div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Accounts</h5>
        </div>
        <div class="widget-content nopadding">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'restaurant-form',
		'htmlOptions'=>array('class'=>'form-horizontal'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="control-group">
		<?php echo $form->labelEx($model,'uid',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->dropDownList($model,'uid',$arr_users); ?>
		<?php echo $form->error($model,'uid'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'name',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'name'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'image',array('class'=>'control-label')); ?>
		<div class="controls">
		<div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
		<div id="container">
		    <a id="pickfiles" href="javascript:;">[Select files]</a> 
		    <a id="uploadfiles" href="javascript:;">[Upload files]</a>
		</div>
		<div id="showimg">
		<?php if($model->image!=""){?>
		<img src="/img/upload/<?php echo $model->image;?>">
		<?php }?>
		</div>
		<?php echo $form->hiddenField($model,'image'); ?>
		<?php echo $form->error($model,'image'); ?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label">Tags</label>
		<div class="controls tags_item">
		<button class="btn btn-primary btn-mini" data-toggle="modal" data-target="#myModal">
		   +ADD
		</button>
		<?php echo CHtml::hiddenField("Restaurant[tags]",'',array('id'=>'Restaurant_tags')); ?>
		</div>
	</div>
	
<!-- 	<div class="control-group"> -->
<!-- 		<label class="control-label">Series</label> -->
<!-- 		<div class="controls"> -->
			<?php  //echo CHtml::checkBoxList('series',$sel_series, $series, array('labelOptions'=>array('style'=>'display:inline-block'),'template' => '<li style="display:inline-block;">{input} {label}</li>','separator'=>'&nbsp;&nbsp;')); ?>
<!-- 		</div> -->
<!-- 	</div> -->

	<div class="control-group">
		<?php echo $form->labelEx($model,'tel',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'tel',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'tel'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'mobile',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'mobile',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'mobile'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'address',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'address'); ?>
		</div>
	</div>
	
	<div class="control-group">
		<?php echo $form->labelEx($model,'start',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'start',array('size'=>60)); ?>
		<?php echo $form->error($model,'start'); ?>
		</div>
	</div>
	
	<div class="control-group">
		<?php echo $form->labelEx($model,'area',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'area',array('size'=>60,'maxlength'=>255)); ?>(多个区号以","隔开.)
		<?php echo $form->error($model,'area'); ?>
		</div>
	</div>
	
	<div class="control-group">
		<?php echo $form->labelEx($model,'zipcode',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'zipcode',array('size'=>60,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'zipcode'); ?>
		</div>
	</div>
	
	<div class="control-group">
		<?php echo $form->labelEx($model,'vip',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->dropDownList($model,'vip',JConfig::item("config.vip"),array('class'=>'span1')); ?>
		<?php echo $form->error($model,'vip'); ?>
		</div>
	</div>

    <div class="control-group">
        <?php echo $form->labelEx($model,'labels',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->checkBoxList($model,'labels', JConfig::item('config.label'), array('labelOptions'=>array('style'=>'display:inline-block'),'template' => '<li style="display:inline-block;">{input} {label}</li>','separator'=>'&nbsp;&nbsp;')); ?>
            <?php echo $form->error($model,'labels'); ?>
        </div>
    </div>
	
	<div class="control-group">
		<?php echo $form->labelEx($model,'sortnum',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'sortnum',array('size'=>60,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'sortnum'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'open_time',array('class'=>'control-label')); ?>
		<div class="controls">
		<div data-date="" class="input-append date datepicker" >
		<?php echo $form->textField($model,'open_time',array('class'=>"span2", 'data-format'=>'hh:mm:ss')); ?>
		<span class="add-on"><i class="icon-th"></i></span>
		</div>
		<?php echo $form->error($model,'open_time'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'close_time',array('class'=>'control-label')); ?>
		<div class="controls">
		<div data-date="" class="input-append date datepicker" >
		<?php echo $form->textField($model,'close_time',array('class'=>"span2", 'data-format'=>'hh:mm:ss')); ?>
		<span class="add-on"><i class="icon-th"></i></span>
		</div>
		<?php echo $form->error($model,'close_time'); ?>
		</div>
	</div>

	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
               	Add tag
            </h4>
         </div>
         <div class="modal-body">
            <?php echo CHtml::dropDownList("aaa", "", $arr_tags,array('id'=>'data_tags','prompt'=>'请选择'));?>
            <?php echo CHtml::dropDownList("bbb", "", array(),array('id'=>'tag_value'));?>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭 </button>
            <button type="button" class="btn btn-primary" id="tag_btn">确定</button>
         </div>
      </div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>
<script type="text/javascript" src="/js/plupload/plupload.full.min.js"></script>
<script type="text/javascript">
var uploader = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'pickfiles', // you can pass in id...
	container: document.getElementById('container'), // ... or DOM Element itself
	url : '<?php echo Yii::app()->createUrl("/upload");?>',
	flash_swf_url : '/js/plupload/Moxie.swf',
	silverlight_xap_url : '/js/plupload/Moxie.xap',
	
	filters : {
		max_file_size : '2mb',
		mime_types: [
			{title : "Image files", extensions : "jpg,gif,png,jpeg"},
			{title : "Zip files", extensions : "zip"}
		]
	},

	init: {
		PostInit: function() {
			document.getElementById('filelist').innerHTML = '';

			document.getElementById('uploadfiles').onclick = function() {
				uploader.start();
				return false;
			};
		},

		FilesAdded: function(up, files) {
			plupload.each(files, function(file) {
				document.getElementById('filelist').innerHTML = '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
			});
		},

		UploadProgress: function(up, file) {
			document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
		},
		FileUploaded: function(uploader,file,responseObject) {
			//document.createElement();

			var msg = responseObject.response;
			var obj = eval('(' + msg + ')');
// 			console.log(obj);
			if(obj.status=="success")
			{
				$("#showimg").html("<img src='/img/upload/"+obj.url+"'>");
				$("#Restaurant_image").val(obj.url);
			}
		},
		Error: function(up, err) {
			document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
		}
	}
});
var arr_item = {};
function addItem(value,text)
{
	if(value=="") return;
	if(!arr_item[value])
	{
		arr_item[value]=true;
	}
	else
	{
		return;
	}
	var html = "<span vid='"+value+"' class='btn btn-sm' style='margin-left:5px;' onclick='delItem(this)'>"+text+" ×</span>";
	$(".tags_item").append(html);
	var tags = $("#Restaurant_tags").val();
	var arr_tags = tags == ""?new Array():tags.split(",");
	arr_tags.push(value);
	$("#Restaurant_tags").val(arr_tags.join(","));
}
function delItem(obj)
{
	var value = $(obj).attr("vid");
	var tags = $("#Restaurant_tags").val();
	var arr_tags = tags.split(",");
	for(var i in arr_tags)
	{
		if(arr_tags[i] == value)
		{
			arr_tags.splice(i,1)
		}
	}
	$("#Restaurant_tags").val(arr_tags.join(","));
	arr_item[value]=false;
	obj.parentNode.removeChild(obj);
}
$(function() {
    $('.datepicker').datetimepicker({
      pickDate: false
    });
    $("#data_tags").change(function(){
		var tag = $(this).val();
		var html = "<option value=''>请选择</option>";
		$.ajax({
			'url': '<?php echo $this->createUrl('/adm/tag/getTagValue')?>?id='+tag,
			'dataType': 'json',
			'beforeSend': function(){
				$("#tag_value").html(html);
			},
			'success': function(item){
				if(item.status == 'success') {
					$.each(item.data, function(k,v){
						html += "<option value='"+v.id+"'>"+v.name+"</option>";
					});
					$("#tag_value").html(html);
				} else {
					alert('error');
				}
			}
		});
	});
	$("#tag_btn").click(
		function(){
			var tagText=$("#data_tags").find("option:selected").text();
			var tagValue=$("#data_tags").val();
			var valText=$("#tag_value").find("option:selected").text();
			var valValue=$("#tag_value").val();
			if(valValue==""||valValue==null)
			{
				alert("both select!");
				return false;
			}
			addItem(tagValue+":"+valValue,tagText+":"+valText);
			$('#myModal').modal('hide');
		}
	);
	<?php 
			if(!$model->isNewRecord)
			{?>
				var tag_json = <?php echo empty($model_tags)?"{}":json_encode($model_tags)?>;
				for(var i in tag_json)
				{
					addItem(i,tag_json[i]);
				}
				
	<?php }	?>
  });
uploader.init();
</script>