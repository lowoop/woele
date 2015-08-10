		<div class='ad'><img height='141' width='100%' src="/img/ad.jpg"></div>        
        
        <section class='CONTENT clear'>
            <div class='forget'>
                <img src="img/forget.gif">
                <h1 class="message">通过邮箱找回密码</h1>
                <input type='text' placeholder='邮箱' id="email" style="display:inline"/>
                <a href="javascript:void 0" class='contain'>忘记密码</a>
            </div>
        </section>
        <script>
        $(".contain").click(function(){
        	var myemail = $("#email").val();
        	$('.valiclass').remove();
        	if(!email(myemail))
        	{
        		tips("#email","邮箱输入错误！");
        		return;
        	}
        	else
        	{
        		$('.valiclass').remove();
        	}
        	$.ajax({
        		url : "<?php echo Yii::app()->createUrl("/findpass");?>",
        		method : "post",
        		data : {email:myemail},
        		dataType : "json",
        		success : function(res){
        			if(res.status=="success")
        			{
        				alert("修改密码链接已经发送到您的邮箱，请登录邮箱查看。");
        			}
        			else
        			{
        				tips("#email",res.msg);
        			}
        		},
        		error : function()
        		{
        			
        		},
        	});
        });
        </script>