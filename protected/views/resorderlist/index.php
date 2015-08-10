<script src="/js/soundjs-0.6.0.min.js"></script>
<div class='ad'><img height='141' width='100%' src="/img/ad.jpg"></div>        
        
        <section class='CONTENT clear'>
            <div class='ordermtitle'>
                <a href="<?php echo Yii::app()->createUrl("/resorderlist");?>" class='<?php echo $status==3?"cur":"";?>'>待接受订单</a><a href="<?php echo Yii::app()->createUrl("/resorderlist")."?status=2";?>" class='<?php echo $status==2?"cur":"";?>'>已接受订单</a><a href="<?php echo Yii::app()->createUrl("/resorderlist")."?status=-2";?>" class='<?php echo $status==-2?"cur":"";?>'>已拒绝订单</a>
            </div>
            <div class='orderms'>
            <?php
            foreach ($data as $value)
            {
            ?>
            <div class="orderm">
                <div class="ordertt">订单详情 <span style="font-weight: normal;">(<?php echo $value->onum;?>) <?php echo date("Y-m-d",$value->create_datetime);?></span></div>
                <div class="roderdbox">
                    <ul class="list" id="slist">
                    <?php
                    foreach ($value->po as $v)
                    {
                    ?>
                    	<li>
                            <span class='cname'><?php echo $v->food->name;?></span>
                            <span class='num'><?php echo $v->num;?>份</span>
                            <span class='fr'>$<?php echo $v->food->price;?></span><br>
<!--                            <span class='red'>Tip:不要辣椒，不要葱</span>-->
                        </li>
                    <?php
                    }
                    ?>
                        <li>送餐费 <span class="fr">$<?php echo $value->fee;?></span></li>
                    </ul>

                </div>
                <div class="roderdbox2">
                    <ul class="list" id="slist">
                            <li><span class="red">总计：</span> <span class="fr red" id="count">$<?php echo $value->total_price;?></span></li>
                     </ul>
                    <p>
                        <span class='hidden'><?php echo $value->create_datetime*1000;?></span>
                        下单时间 -  <?php echo date("H:i:s",$value->create_datetime);?><i>|</i> <span class='fr'>等待：<span class='blod'>00:00:00</span></span>
                    </p>
                </div>
                <?php if($status == 3){?>
                <div class='option' data-id="<?php echo $value->id;?>">
                    <div><span class='radselect' data-value='15'></span> 15分钟</div><div><span class='radselect' data-value='30'></span> 30分钟</div>
                    <button class="apply">接受订单</button><button class="refuse">拒绝订单</button>
                </div>
                <?php }?>
            </div>
            <?php
            }
            ?>
            </div>
            <div class="page_more">
            	<?php   
				    $this->widget('CLinkPager',array( 
				    	'header'=>'', 
						'htmlOptions'=>array('class'=>'myPager'),
				        'firstPageLabel'=>'首页',  
				        'firstPageCssClass'=>'first',  
				        'lastPageLabel'=>'末页',  
				        'lastPageCssClass'=>'first',  
				        'prevPageLabel'=>'上一页',
						'previousPageCssClass'=>'next', 
				        'nextPageLabel'=>'下一页',  
				        'nextPageCssClass'=>'next',
				        'selectedPageCssClass'=>'isNow',  
				        'pages'=>$pages,  
				        'maxButtonCount'=>5,  
				        )  
				    );  
				?>
			</div>
        </section>
        <script type="text/javascript">
         //订单声音
        createjs.Sound.alternateExtensions = ["mp3"];
        createjs.Sound.registerSound("mp3/tip.mp3", "sound");
        function ordercome(){
            console.log("000");
            var instance = createjs.Sound.play("sound");
        }
        function initPage()
        {
        	 $('.orderm .radselect').click(function(){
                $(this).parent().parent().find('.radselect').removeClass('active');
                $(this).addClass('active');
            });
            //倒计时
        	$('.orderm .hidden').each(function(index, el) {
	            var _ = $(this);
	            var time = parseInt(_.text());
	            var tar = _.parent().find('.blod');
	            //console.log(tar);
	            var str = '';
	            var TM = setInterval(function(){
	                var now = new Date().getTime();
	                var leftTime = now - time;
	                var leftsecond = parseInt(leftTime / 1000);
	                var day1 = Math.floor(leftsecond / (60 * 60 * 24));
	
	                if(day1>1){
	                    str='大于1天';
	                    tar.text(str);
	                    clearInterval(TM);
	                    return;
	                }
	
	                var hour = Math.floor((leftsecond - day1 * 24 * 60 * 60) / 3600);
	                var minute = Math.floor((leftsecond - day1 * 24 * 60 * 60 - hour * 3600) / 60);
	                var second = Math.floor(leftsecond - day1 * 24 * 60 * 60 - hour * 3600 - minute * 60);
	
	                if(hour<10){
	                    hour = '0'+hour;
	                }
	                if(minute<10){
	                    minute = '0'+minute;
	                }
	                if(second<10){
	                    second = '0'+second;
	                }
	                str = hour+':'+minute+':'+second;
	                tar.text(str);

            	},1000);
        	});
        }
        $(function(){
	        //操作订单
	        $('.orderm .option button').click(function(event) {
	            var self = this;
	            if($(this).attr('class')=="apply")
	            {
		        	var time = $(this).parent().find(".active").attr('data-value');
					if(!time)
					{
						alert("请选择时间!");
						return false;
					}
					var type = "apply";
	            }
	            else
	            {
					var type = "refuse";
					var time = "";
	            }
	            var id = $(this).parent().attr("data-id");
	            $.ajax( {    
				    url:'<?php echo Yii::app()->createUrl("/resorderlist/apply"); ?>',// 跳转到 action    
				    data:{    
				    	oid:id,
				    	time:time,
				    	type:type
				    },    
				    type:'post',    
				    cache:false,    
				    dataType:'json',    
				    success:function(data) {    
				        if(data.msg =="success" ){ 
				        	$(self).parents('.orderm').remove();
				        }else{    
				            alert("操作失败!");
				            return false; 
				        }    
				     },    
				     error : function() {    
				          // view("异常！");    
				          alert("http error!"); 
				          return false;   
				     }    
				});
	            //ajax成功后操作
	            //console.log($(this).parents('.orderm'));
	            
	        });
     		initPage();
     		setInterval("getData()",10000);
        });
        function getData()
        {
        	$.ajax( {    
			    url:'<?php echo Yii::app()->createUrl("/resorderlist/Refresh"); ?>',// 跳转到 action    
			    data:{    
			    	status:<?php echo $status;?>
			    },    
			    type:'post',    
			    cache:false,    
			    dataType:'json',    
			    success:function(data) {    
			        if(data.msg =="success" )
				    { 
			        	if(data.total > 0)
			        	{
			        		var str = "";
			        		$.each(data.data,function(i, value) {
			        			str += '<div class="orderm">';
			        			str += '<div class="ordertt">(New)订单详情 <span style="font-weight: normal;">('+value.oid+') '+value.create_date+'</span></div><div class="roderdbox"><ul class="list" id="slist">';
			        			$.each(value.foods,function(j,food){
			        				str += '<li><span class="cname">'+food.name+'</span><span class="num">'+food.num+'份</span><span class="fr">$'+food.price+'</span><br></li>';
			        			});
			        			str += ' <li>送餐费 <span class="fr">$'+value.fee+'</span></li></ul></div>';
			        			str += '<div class="roderdbox2"><ul class="list" id="slist"><li><span class="red">总计：</span> <span class="fr red" id="count">$'+value.total+'</span></li></ul><p><span class="hidden">'+value.microtime+'</span>下单时间 -  '+value.create_time+'<i>|</i> <span class="fr">等待：<span class="blod">00:00:00</span></span></p></div>';
			        			if(value.status==3)
			        			{
			        				str += '<div class="option" data-id="'+value.id+'"><div><span class="radselect" data-value="15"></span> 15分钟</div><div><span class="radselect" data-value="30"></span> 30分钟</div><button class="apply">接受订单</button><button class="refuse">拒绝订单</button></div>';
			        			}
			        			str += '</div>';
			        		});
			        		$(".orderms").prepend(str);
			        		initPage();
			        		ordercome();
			        	}
			        }
			        else{    
			            console.log("refresh errors");
			            return false; 
			        }    
			     },    
			     error : function() {    
			          // view("异常！");    
			          alert("http error!"); 
			          return false;   
			     }    
			});
        }
//         $("#apply").click(function(){
// // 			

//         });
        </script>