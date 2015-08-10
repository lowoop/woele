<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/main.css">
        <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
        <script>window.jQuery || document.write('<script src="/js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
        <script src="/js/vendor/modernizr-2.8.3.min.js"></script>
        <script src="/js/jquery.event.swipe.js"></script>
        <script src="/js/jquery.geocomplete.js"></script>
        <script src="/js/jquery.md5.js"></script>

    </head>
    <body>
    	
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <header>
        	<div class="div">
        		<a class="logo" href="/" title="I'm hungry"></a>
        		<?php if(Yii::app()->user->isGuest){?>
        		<button id="register" class="userbtn">注册</button>
        		<button id="login" class="userbtn">登陆</button>
        		<?php }else{?>
        		<div class='loginuser fr'>
                    <img src="/img/portrait.jpg"> <?php echo Yii::app()->user->name;?> <span class='arrow'></span>
                    <div class='pop' style="z-index:100;">
                        <span class='up'></span>
                        <?php if(Yii::app()->user->role==="user"){?>
		        		<a href="<?php echo $this->createUrl('/settings')?>" class="mar10">个人设置</a><br/>
		        		<a href="<?php echo $this->createUrl('/orderlist')?>" >历史订单</a><br/>
		        		<?php }?>
		        		<?php if(Yii::app()->user->role==="admin"){?>
		        		<a href="<?php echo $this->createUrl('/adm')?>" class="mar10">后台管理</a><br/>
		        		<?php }?>
		        		<?php if(Yii::app()->user->role==="shop"){?>
		        		<a href="<?php echo $this->createUrl('/settings')?>" class="mar10">个人设置</a><br/>
		        		<a href="<?php echo $this->createUrl('/resorderlist')?>" >餐厅订单</a><br/>
		        		<?php }?>
                        <a href="<?php echo $this->createUrl('/logout')?>">安全退出</a>
                    </div>
                </div>
        		<?php }?>
        	</div>
        </header>
        <div id="content-header">
		    <?php if(isset($this->breadcrumbs)):?>
		      <?php $this->widget('zii.widgets.CBreadcrumbs', array(
		        'links'=>$this->breadcrumbs,
		        'htmlOptions'=>array('id'=>'breadcrumb'),
		        'activeLinkTemplate'=>'<a class="tip-bottom" href="{url}">{label}</a>',
		        'inactiveLinkTemplate'=>'<a class="current" href="javascript:void(0);">{label}</a>',
		        'separator'=>'->',
		      )); ?>
		    <?php endif?>
  		</div>	
		<?php echo $content; ?>
        <footer>
 			<span class="quetion">有问题联系我们</span>
 			<div class="connect">
                客服热线：0434-371-266<span style="color:#6b6a6a;padding: 0 10px;">|</span>客服微信：woele_au
 			</div>
        </footer>
        
         <!-- 设置成功 pop-->
         
	    <div class="setover" id="setover_box">
	      <div class="setclose close">╳</div>
	      <div class="setinwp">
	      	<h3>请输入您的登录信息，或者选择使用新浪微博登录&nbsp;&nbsp;<a href="<?php echo $this->createUrl('/site/auth?provider=weibo')?>"><img align="absmiddle" src="/img/sina.jpg" /></a></h3>
	      	<span class='red' id="msg" style="display:none;"></span>
	      	<input type="text" id="username" placeholder="请输入用户名/邮箱/手机号码" tabindex="1"/>
	      	<input type="password" id="password" placeholder="请输入密码" tabindex="2" />
            <input type="text" id="yzm" style="width:80px;height: 30px;"><?php $this->widget('CCaptcha',array('captchaAction'=>'/site/captcha','showRefreshButton'=>true,'buttonLabel'=>'换一张','clickableImage'=>true,'imageOptions'=>array('alt'=>'点击换图','title'=>'点击换图','style'=>'cursor:pointer'))); ?>
	      	<div class="passwordset"><span class='radselect'></span> 记住密码&nbsp;&nbsp;&nbsp; <a class="red" href="<?php echo Yii::app()->createUrl("/findpass");?>">忘记密码?</a></div>
	      	<button class="setform loginbtn">登陆</button><button class="setform close fr">取消</button>
	      </div>
	    </div>
	    
        <script src="/js/jquery-plugin-pop.js"></script>
        <script src="/js/plugins.js"></script>
        <script src="/js/main.js"></script>
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            /*
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
                        function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
                        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
                        e.src='//www.google-analytics.com/analytics.js';
                        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
                        ga('create','UA-XXXXX-X','auto');ga('send','pageview');*/
            
        </script>
    </body>
    <script type="text/javascript">
	    $(".loginbtn").on('click', function(){
	    	$("#msg").fadeOut();
			var username = $("#username").val();
			var password = $("#password").val();
			var yzm = $("#yzm").val();
			if($(".radselect").hasClass("active"))
			{
				var remember = 1;
			}
			else
			{
				var remember = 0;
			}
			if(username == "" || password == "")
			{
				$("#msg").html("Tip:请输入用户名/密码!");
				$("#msg").fadeIn();
				return false;
			}
            if(yzm == "")
            {
                $("#msg").html("Tip:请输入验证码!");
                $("#msg").fadeIn();
                return false;
            }
			$.ajax({
				'url': '<?php echo $this->createUrl('/login')?>',
				'type': 'post',
				'data' : {'username':username,'password':$.md5(password),'rememberMe':remember,'yzm':yzm},
				'dataType': 'json',
				'success': function(ret){
					if(ret.status == 'success')
					{
						 window.location.href="<?php echo strpos(Yii::app()->request->urlReferrer,Yii::app()->request->hostInfo)===0?Yii::app()->request->urlReferrer:"/";?>";
					}
					else
					{
                        if(ret.status == 'errcode')
                        {
                            $("#yw0_button").click();
                            $("#msg").html("Tip:验证码输入错误!");
                            $("#msg").fadeIn();
                        }
                        else
                        {
                            $("#yw0_button").click();
                            $("#msg").html("Tip:用户名或密码错误!");
                            $("#msg").fadeIn();
                        }
					}
				}
			});
		});
		$("#register").on('click', function(){
			window.location.href='<?php echo $this->createUrl("/register");?>';		
		});
		$('#setover_box').keydown(function(e){
			if(e.keyCode==13){
				$(".loginbtn").click();
			}
		});
    </script>
</html>