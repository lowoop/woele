<?php 
Yii::app()->getClientScript()->registerCoreScript('jquery');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?php echo $this->module->assetsUrl;?>/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo $this->module->assetsUrl;?>/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="<?php echo $this->module->assetsUrl;?>/css/fullcalendar.css" />
<link rel="stylesheet" href="<?php echo $this->module->assetsUrl;?>/css/matrix-style.css" />
<link rel="stylesheet" href="<?php echo $this->module->assetsUrl;?>/css/matrix-media.css" />
<link rel="stylesheet" href="<?php echo $this->module->assetsUrl;?>/css/bootstrap-datetimepicker.min.css" />
<link href="<?php echo $this->module->assetsUrl;?>/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo $this->module->assetsUrl;?>/css/jquery.gritter.css" />
<link rel="stylesheet" href="<?php echo $this->module->assetsUrl;?>/css/custom.css" />
<!--<link href='http://fonts.useso.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>-->
</head>
<body>
<!--Header-part-->
<div id="header">
  <h1><a href="dashboard.html">Matrix Admin</a></h1>
</div>
<!--close-Header-part--> 
<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse" >
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text"><?php echo Yii::app()->user->name;?></span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="#"><i class="icon-user"></i> My Profile</a></li>
        <li class="divider"></li>
        <li><a href="#"><i class="icon-check"></i> My Tasks</a></li>
        <li class="divider"></li>
        <li><a href="javascript:;" class="logout" target="_self"><i class="icon-key"></i> Log Out</a></li>
      </ul>
    </li>
    <li class=""><a href="/logout" target="_self"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
  </ul>
</div>
<!--close-top-Header-menu-->

<!--sidebar-menu-->
<div id="sidebar">
  <?php 
  $current = isset($this->module)?'/'.$this->module->id.'/'.$this->id:'/'.$this->id;
  $arr_menu = array();
  foreach (JConfig::item('bmenu.menu') as $key=>$value)
  {
  	$url = '/'.implode('/', explode('_', $key));
  	$arr_menu[$key]['name'] = $value['name'];
  	$arr_menu[$key]['icon'] = $value['icon'];
  	$arr_menu[$key]['open'] = false;
  	if($value['url'])
  	{
  		$arr_menu[$key]['url'] = $url;
  	}
  	else
  	{
  		$arr_menu[$key]['url'] = "###";
  	}
  	if(substr($url, 0, strrpos($url, '/')) == ($current))
  	{
  		$arr_menu[$key]['active'] = true;
  	}
  	else 
  	{
  		$arr_menu[$key]['active'] = false;
  	}
  	if(!empty($value['submenu']))
  	{
  		foreach ($value['submenu'] as $k=>$v)
  		{
  			$url1 = '/'.implode('/', explode('_', $k));
  			$arr_menu[$key]['submenu'][$k]['name'] = $v['name'];
  			$arr_menu[$key]['submenu'][$k]['url'] = $url1;
	  		if(substr($url1, 0, strrpos($url1, '/')) == ($current))
		  	{
		  		$arr_menu[$key]['open'] = true;
		  		$arr_menu[$key]['active'] = false;
		  		$arr_menu[$key]['submenu'][$k]['active'] = true;
		  	}
		  	else 
		  	{
		  		$arr_menu[$key]['submenu'][$k]['active'] = false;
		  	}
  		}
  	}
  }
	
  ?>
  <ul>
  <?php foreach ($arr_menu as $key=>$value){?>
  	<li class="<?php if(!empty($value['submenu'])) echo "submenu";?><?php if($value['active']) echo " active";?><?php if($value['open']) echo " open";?>"><a href="<?php echo $value['url'];?>"><i class="icon <?php echo $value['icon'];?>"></i> <span><?php echo $value['name'];?></span><?php if(!empty($value['submenu'])){?><span class="label label-important"><?php echo count($value['submenu']);?></span><?php }?></a>
  <?php if(!empty($value['submenu'])){?>
 		<ul>
 		<?php foreach ($value['submenu'] as $k=>$v){?>
 		<li class="<?php if($v['active']) echo "active";?>"><a href="<?php echo $v['url'];?>"><?php echo $v['name'];?></a></li>
 		<?php }?>
 		</ul>
  <?php }?>
  		</li>
  <?php }?>
  </ul>
</div>
<!--sidebar-menu-->

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
	  <?php if(isset($this->breadcrumbs)):?>
	      <?php $this->widget('zii.widgets.CBreadcrumbs', array(
	        'links'=>$this->breadcrumbs,
	      	'homeLink'=>'<a href="/b">首页</a>',
	        'htmlOptions'=>array('id'=>'breadcrumb'),
	        'activeLinkTemplate'=>'<a class="tip-bottom" href="{url}">{label}</a>',
	        'inactiveLinkTemplate'=>'<a class="current" href="javascript:void(0);">{label}</a>',
	        'separator'=>'',
	      )); ?>
	    <?php endif?>
  </div>
<!--End-breadcrumbs-->
<div class="container-fluid">
<?php echo $content;?>
</div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->

<div class="row-fluid">
  <div id="footer" class="span12"> 2013 &copy; Matrix Admin. Brought to you by <a href="http://themedesigner.in/">Themedesigner.in</a> </div>
</div>

<!--end-Footer-part-->
</body>
<script src="<?php echo $this->module->assetsUrl;?>/js/excanvas.min.js"></script> 
<script src="<?php echo $this->module->assetsUrl;?>/js/jquery.ui.custom.js"></script> 
<script src="<?php echo $this->module->assetsUrl;?>/js/bootstrap.min.js"></script> 
<script src="<?php echo $this->module->assetsUrl;?>/js/bootstrap-datetimepicker.js"></script> 
<script src="<?php echo $this->module->assetsUrl;?>/js/jquery.gritter.min.js"></script> 
<script src="<?php echo $this->module->assetsUrl;?>/js/matrix.js"></script> 
<script src="<?php echo $this->module->assetsUrl;?>/js/select2.min.js"></script> 
<script src="<?php echo $this->module->assetsUrl;?>/js/matrix.popover.js"></script> 
<script src="<?php echo $this->module->assetsUrl;?>/js/jquery.dataTables.min.js"></script> 


<script type="text/javascript">
  // This function is called from the pop-up menus to transfer to
  // a different page. Ignore if the value returned is a null string:


// resets the menu selection upon entry to this page:
function resetMenu() {
   document.gomenu.selector.selectedIndex = 2;
}
// $.gritter.add({
// 	title:	'Important messages',
// 	text:	'You have 12 unread messages.',
// 	image: 	'',
// 	sticky: true
// });
function adminGetMsg()
{
	$.ajax({
		type:'post',
		url: '<?php echo Yii::app()->createUrl("/adm/default/GetMessage")?>',
		dataType: 'json',
			data:{id:1},
			success: function(data){
				if(data.status=='yes') {
					$.gritter.add({
						title:	'Important messages',
						text:	data.msg,
						image: 	'<?php echo $this->module->assetsUrl;?>/img/demo/envelope.png',
						sticky: false
					});
				} else {
					
				}
			}
	});
}
$(function(){
	setInterval("adminGetMsg()",20000);
});
</script>
</html>
