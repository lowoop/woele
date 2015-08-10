		<div class='ad'><img height='141' width='100%' src="/img/ad.jpg"></div>        
        
        <section class='CONTENT clear'>
            <div class='forget'>
                <img src="img/forget.gif">
                <h1 class="message">请重新设置密码</h1>
                <input class='password' placeholder='输入您的密码' type='password'/><br>
                <input class='password1' placeholder='确认您的密码' type='password'/><br>
                <input type="hidden" class="token" value="<?php echo $token;?>">
                <a href="javascript:void 0" class='contain'>提交</a>
            </div>
        </section>
        <script>
        $(".contain").click(function(){
        	var token = $(".token").val();
        	var password = $(".password").val();
        	var password1 = $(".password1").val();
        	$('.valiclass').remove();
        	if(password != password1 || password == "")
        	{
        		tips(".password1","亲，两次输入密码不一致哦~");
        		return;
        	}
        	else
        	{
        		$('.valiclass').remove();
        	}
        	$.ajax({
        		url : "<?php echo Yii::app()->createUrl("/changepassword");?>",
        		method : "post",
        		data : {password : $.md5(password), token : token},
        		dataType : "json",
        		success : function(res){
        			if(res.status=="success")
        			{
        				$("#login").popwindow({content:$(".setover")});
        				alert(res.msg);
        			}
        			else
        			{
        				alert(res.msg);
        			}
        		},
        		error : function()
        		{
        			
        		},
        	});
        });
        </script>