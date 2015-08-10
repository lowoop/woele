<?php
/* @var $this AdminController */
/* @var $model User */

$this->breadcrumbs=array(
	'Common'=>array('index'),
);
?>
<div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>基本配置</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="?" method="post" class="form-horizontal">
            <div class="control-group">
              <label class="control-label">配送费：</label>
              <div class="controls">
                $<input type="text" name="fee" value="<?php echo array_key_exists("fee", $config)?$config['fee']:"";?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">首单配送费打折：</label>
              <div class="controls">
                <input type="text" name="first_discount" value="<?php echo array_key_exists("first_discount", $config)?$config['first_discount']:'';?>">%
              </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-success">保存</button>
            </div>
          </form>
        </div>
</div>
<div class="widget-box">
    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
        <h5>首页通知</h5>
    </div>
    <div class="widget-content nopadding">
        <form action="?" method="post" class="form-horizontal">
            <div class="control-group">
                <label class="control-label">通知：</label>
                <div class="controls">
                    <input type="text" name="notice" class="span6" value="<?php echo array_key_exists("notice", $config)?$config['notice']:"";?>">
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success">保存</button>
            </div>
        </form>
    </div>
</div>
<div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>邮箱配置</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="?" method="post" class="form-horizontal">
          	<div class="control-group">
              <label class="control-label">smtp主机：</label>
              <div class="controls">
                <input type="text" id="host" name="host" value="<?php echo array_key_exists("host", $mail)?$mail['host']:"";?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">smtp端口：</label>
              <div class="controls">
                <input type="text" name="port" id="port" value="<?php echo array_key_exists("port", $mail)?$mail['port']:"";?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">发送账号：</label>
              <div class="controls">
                <input type="text" name="username" id="username" value="<?php echo array_key_exists("username", $mail)?$mail['username']:"";?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">密码：</label>
              <div class="controls">
                <input type="password" name="password" id="password" value="<?php echo array_key_exists("password", $mail)?$mail['password']:'';?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">发送人昵称：</label>
              <div class="controls">
                <input type="text" name="nickname" id="nickname" value="<?php echo array_key_exists("nickname", $mail)?$mail['nickname']:'';?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">接收邮箱：</label>
              <div class="controls">
                <input type="text" name="receiver" id="receiver" value="<?php echo array_key_exists("receiver", $mail)?$mail['receiver']:'';?>">
              </div>
            </div>
            <div class="form-actions">
              <a class="btn btn-warning mailtest">测试</a>
              <button type="submit" class="btn btn-success">保存</button>
            </div>
          </form>
        </div>
</div>
<div class="modal fade" id="rec_div" style="width:800px;margin-left:-400px;">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
               	 添加图片
            </h4>
         </div>
         <div class="modal-body">
	          <div class="form-horizontal">
	            <div class="control-group">
	              <div >
	                <div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
					<div id="container">
					    <a id="pickfiles" href="javascript:;">[选择图片]</a> 
					    <a id="uploadfiles" href="javascript:;">[上传]</a>
					</div>
					<div id="showimg">
					</div>
					<?php echo CHtml::hiddenField('myimage'); ?>
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
<div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>首页广告位</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="?" method="post" class="form-horizontal">
          <input type="hidden" value="true" name="adconfig">
          	<div id="adver">
          		<?php if(array_key_exists("ad", $config))
          		{
          			foreach ($config['ad'] as $key=>$value)
          			{
          				echo '<div class="control-group"><label class="control-label">广告链接:</label><div class="controls"><input class="span4" type="hidden" name="adlink[]" value="'.$value.'"><input type="hidden" name="adimg[]" value="'.$key.'"> <a href="###" class="btn btn-mini btn-danger delad">删除广告位</a><br><img style="max-width:600px;margin-top:10px;" src="/img/ad/'.$key.'"></div></div>';
          			}
          		}
          			
          		?>
          	</div>
            <div class="form-actions">
              <a class="btn btn-warning" data-toggle="modal" href="#rec_div" >添加广告位</a> <button type="submit" class="btn btn-success">保存</button>
            </div>
          </form>
        </div>
</div>
<script type="text/javascript" src="/js/plupload/plupload.full.min.js"></script>
<script type="text/javascript">
var uploader = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'pickfiles', // you can pass in id...
	container: document.getElementById('container'), // ... or DOM Element itself
	url : '<?php echo Yii::app()->createUrl("/upload/ad");?>',
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
// 				uploader.start();
			});
		},

		UploadProgress: function(up, file) {
			//document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
		},
		FileUploaded: function(uploader,file,responseObject) {
			//document.createElement();

			var msg = responseObject.response;
			var obj = eval('(' + msg + ')');
// 			console.log(obj);
			if(obj.status=="success")
			{
				$("#showimg").html("<img src='/img/ad/"+obj.url+"'>");
				$("#myimage").val(obj.url);
			}
		},
		Error: function(up, err) {
			document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
		}
	}
});
uploader.init();
$(".mailtest").click(function(){
	var host = $("#host").val();
	var port = $("#port").val();
	var username = $("#username").val();
	var password = $("#password").val();
	var nickname = $("#nickname").val();
	var receiver = $("#receiver").val();
	$.ajax({
		type:'post',
		url: '<?php echo Yii::app()->createUrl("/adm/common/mailtest")?>',
		dataType: 'json',
			data:{
				host : host,
				port : port,
				username : username,
				password : password,
				nickname : nickname,
				receiver : receiver
			},
			success: function(data){
				if(data.status=='success') {
					alert("邮件发送成功!");
				} else {
					alert("邮件发送失败!");
				}
			}
	});
});
$("#ok_btn").click(function(){
	var img = $("#myimage").val();
	if(img == "")
	{
		alert("请上传一张图片!");
		return false;
	}
	var html = '<div class="control-group"><label class="control-label">广告链接:</label><div class="controls"><input class="span4" type="hidden" name="adlink[]"><input type="hidden" name="adimg[]" value="'+img+'"> <a href="###" class="btn btn-mini btn-danger delad">删除广告位</a><br><img style="max-width:600px;margin-top:10px;" src="/img/ad/'+img+'"></div></div>';
	$("#adver").append(html);
	$('#rec_div').modal('hide');
});
$(".delad").live('click',function(){
	if(!confirm("确定要删除?")) return false;
	$(this).parent().parent().remove();
});
</script>