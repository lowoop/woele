<?php $this->widget('CCaptcha',array('showRefreshButton'=>true,'buttonLabel'=>'换一张','clickableImage'=>true,'imageOptions'=>array('alt'=>'点击换图','title'=>'点击换图','style'=>'cursor:pointer'))); ?>
<input type="text" id="yzm"><a href="###" onclick="aaa()">验证</a>
<script>
function aaa()
{
	var code = $("#yzm").val();
	$.ajax( {    
	    url:'<?php echo Yii::app()->createUrl("/test/verify"); ?>',// 跳转到 action    
	    data:{    
	    	code : code,
	    },    
	    type:'post',    
	    cache:false, 	    
	    dataType:'json',    
	    success:function(data) {    
	        if(data.msg =="success" ){ 
	            alert("成功!");     
	        }else{    
	            alert("失败!");
	        }    
	     },    
	     error : function() {    
	          // view("异常！");    
	          alert("异常！"); 
	          return false;   
	     }    
	});  
}
</script>