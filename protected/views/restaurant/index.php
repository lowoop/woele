		<div class='ad'><img height='141' width='100%' src="/img/ad.jpg"></div>        
        
        <section class='CONTENT clear'>
            <div class='LEFT fl'>
                <div class='restaurant'>
                    <a href='' class='pic'><img src="/img/upload/<?php echo $restaurant->image;?>"></a>
                    <div class='detail fr'>
                        <h1><?php echo $restaurant->name;?> <span class='<?php echo strtotime(date("Y-m-d ").$restaurant->open_time)<=time()&&strtotime(date("Y-m-d ").$restaurant->close_time)>=time()?"ropen":"rclose";?>'></span></h1>
                        <p>
                            商户地址：<?php echo $restaurant->address;?><br>
                            电话：<?php echo $restaurant->tel;?><br>
                            支付：<span class='pay kamc'></span> <span class='pay kavisa'></span> <span class='pay kacash'></span>
                        </p>
                        <span class='other ot2'></span><span class='ww'><?php echo $restaurant->start;?></span><span class='other ot3'></span><span class='ww'><?php echo substr($restaurant->open_time,0,-3);?> - <?php echo substr($restaurant->close_time,0,-3);?></span>
                    </div>
                </div>

                <div class='rtype'>
                	<span class="foodtype cur" style="cursor: pointer">全部</span>
                	<?php foreach ($types as $key=>$value){?>
                	<span class="foodtype" style="cursor: pointer"><?php echo $key;?></span>
                	<?php }?>
                    <div class='rarrow'></div>

                </div>
                <script type="text/javascript">
                    $('.rtype .rarrow').click(function(event) {
//                         console.log($(this).parent());
                        $(this).parent().toggleClass('rhover');
                    });
                </script>

                <?php foreach ($foods as $value){?>
                <div class='clist f_<?php echo $value['type'];?>'>
                    <a class='picimg' href="" target='_blank'>
                        <img src="/img/upload/<?php echo $value['image'];?>"/>
                    </a>
                    <div class='describe'>
                        <h3><span class='cname' data-id='<?php echo $value['id'];?>'><?php echo $value['name'];?><?php echo $value['rec'] == 1?"<i class='tui'>推荐</i></span>":"";?></span> $<span class='price' discount='<?php echo $value['discount'];?>'><?php echo $value['price'];?></span></h3>
                        <p><?php echo $value['desc'];?></p>
                        <a href="javascript:void(0)" class='want'>我要这个</a><?php echo $value['discount']>0?"<span title='减外卖费哦~' class='nowaimai'></span>":"";?>
                    </div>
                </div>
                <?php }?>
            </div>
            <div class='RIGHT fr'>
                <div id='tofix'>
                <div class='rordertt'><span class='delete'></span>订单详情</div>
                <div style='background:#f7f7f7'>
                    <div class='roderdbox'>
                        选择送餐时间  <div class='fr pickdate'><span class="radselect active" data-value="today"></span> 今天 &nbsp; <span style="display: none;"><span class="radselect" data-value="tomorrow"></span> 明天</span></div>
                        <div class='timeselect'>
                            <span class='textshow'>马上</span>
                            <div class='show'>
                                <ul>
                                    <li>马上</li>
                                    <?php
                                        $hour = date("H");
                                        $hour = max(array(10,$hour));
                                        for($i=$hour;$i<19;$i++)
                                        {
                                            echo "<li>".$i.":00---".$i.":30</li><li>".$i.":30---".($i+1).":00</li>";
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <ul class='slist' id='slist'>
                            <!--
                            <li>
                                <span class='cname'>西葫芦鸡蛋</span>
                                <span class='jian'></span> <span class='num'>4</span> <span class='jia'></span>
                                <span class='fr'>$808</span>
                            </li>
                            -->
                            
                        </ul>
                        <p>
                            送餐费 <span class='fr'>$<?php echo JConfig::getFee();?><span id="fee"></span></span><br>
                            <span class='red'>总计：</span><span class='fr red' id='count'>0</span><br>
                        </p>
                    </div>
                </div>
                <a href="###" class='rordersubmit'>就这些，买单</a>
            </div>
            </div>
        </section>
        <script src="/js/jquery-plugin-pop.js"></script>
        <script src="/js/plugins.js"></script>
        <script src="/js/main.js"></script>
        <script type="text/javascript">
        	$(function(){
        		//单选
                $('.radselect').click(function(){
                    $('.radselect').removeClass('active');
                    $(this).addClass('active');
                });
            });
            //漂浮
            var rtop = $('#tofix').offset().top;
            $(window).scroll(function(event) {
                var top = $(this).scrollTop();
                //console.log(top,rtop);
                if(top>rtop){
                    $('#tofix').addClass('fixed');
                }else{
                     $('#tofix').removeClass('fixed');
                }
            });
            //点菜
            $('.clist .want').click(function(event) {
                var obj = $(this).parents('.clist');
                var cname = obj.find('h3 span.cname').text();
                var price = obj.find('h3 span.price').text();
                var discount = obj.find('h3 span.price').attr('discount');
                var dataid = obj.find('h3 span.cname').attr('data-id');
                var str = "<li data-cname='"+cname+"' data-id='"+dataid+"'>";
                    str += "<span class='cname'>"+cname+"</span>";
                    str += "<a href='javascript:void 0' class='jian'></a> <span class='num'>1</span> <a href='javascript:void 0' class='jia'></a>";
                    str += "<span class='fr' discount='"+discount+"'>"+price+"</span>";
                    str += "</li>";
                var targ = $("[data-cname = '"+cname+"']");
                //console.log(targ.length);
                if(targ.length==0){
                    $('#slist').append(str);
                }else{
                    var num = targ.find('.num').text();
                    num = parseInt(num);
                    num++;
                    targ.find('.num').text(num);
                }
                getallprice();
            });
            //菜数量控制+
            $(document).on('click', '.slist li .jia', function(event) {
                var numobj = $(this).prev('span');
                var num = parseInt(numobj.text());
                num++;
                numobj.text(num);
                getallprice();
            });
            //菜数量控制-
            $(document).on('click', '.slist li .jian', function(event) {
                var numobj = $(this).next('span');
                var num = parseInt(numobj.text());
                num--;
                if(num==0) $(this).parent().remove();
                numobj.text(num);
                getallprice();
            });
            //js乘法
            function accMul(arg1,arg2)
            {
                var m=0,s1=arg1.toString(),s2=arg2.toString();
                try{
                    if(s1.split(".")[1] != undefined )
                        m+=s1.split(".")[1].length
                }catch(e){}
                try{
                    if(s2.split(".")[1] != undefined )
                        m+=s2.split(".")[1].length
                }catch(e){}
                return Number(s1.replace(".",""))*Number(s2.replace(".",""))/Math.pow(10,m)
            }
            function accAdd(arg1,arg2){
                var r1,r2,m;
                try{r1=arg1.toString().split(".")[1].length}catch(e){r1=0}
                try{r2=arg2.toString().split(".")[1].length}catch(e){r2=0}
                m=Math.pow(10,Math.max(r1,r2))
                return (arg1*m+arg2*m)/m
            }
            function accSubtr(arg1,arg2){
                var r1,r2,m,n;
                try{r1=arg1.toString().split(".")[1].length}catch(e){r1=0}
                try{r2=arg2.toString().split(".")[1].length}catch(e){r2=0}
                m=Math.pow(10,Math.max(r1,r2));
//动态控制精度长度
                n=(r1>=r2)?r1:r2;
                return ((arg1*m-arg2*m)/m).toFixed(n);
            }
            //计算总价
            function getallprice(){
                var count = 0;
                var discount = 0;
                var fee = <?php echo JConfig::getFee();?>;
                $('#slist li').each(function(index, el) {
                    var self = $(this);
//                     console.log(self.find('.fr').text()+0);
                    var price = self.find('.fr').text();
                    var num = parseInt(self.find('.num').text());
                    var dis_count = self.find('.fr').attr('discount');//打折
                    count = accAdd(count,accMul(price,num));
                    discount = accAdd(discount,accMul(dis_count,num));
                });
                discount = Math.min(discount,fee);
                count = accAdd(count,fee);
                count = accSubtr(count,discount);
                if(discount>0)
                {
                    $('#fee').text('-'+discount);
                }
                else
                {
                    $('#fee').text('');
                }
                $('#count').text('$'+count);
            }
            //删除全部
            $('.rordertt .delete').click(function(event) {
                $('#slist li').remove();
                getallprice();
            });
            //时间选择
            $('.timeselect li').click(function(event) {
                $('.timeselect .textshow').text($(this).text());
            });
            $('.rordersubmit').click(function(){
            	var query = "";
            	var limit = <?php echo $restaurant->start;?>;
            	var count = $("#count").html().substr(1);
            	var pickdate = $(".pickdate").find(".active").attr("data-value");
            	var picktime = $(".textshow").html();
            	$("#slist li").each(function(){
            		//alert($(this).attr("data-cname"));
            		//alert($(this).find(".num").text());
            		query += ","+$(this).attr("data-id")+":"+$(this).find(".num").text();
            	});
            	if(query=="")
            	{
            		alert("请至少选择一种食物!");
            		return false;
            	}
            	if(count - limit - <?php echo JConfig::getFee();?> < 0)
            	{
            		alert("对不起,您订餐总价没有达到餐厅起送价!");
            		return false;
                }
            	var url = "<?php echo Yii::app()->createUrl("/order");?>?query="+encodeURIComponent(query)+"&date="+pickdate+"&time="+encodeURIComponent(picktime);
            	window.location.href=url;
            });
            $(".foodtype").click(function(){
                var type = $(this).html();
                if(type == "全部")
                {
                	$(".foodtype").removeClass("cur");
                	$(this).addClass("cur");
                	$(".clist").show();
                	return;
                }
//                 if($(this).hasClass("cur"))
//                 {
//                 	$(this).removeClass("cur");
//                 	$(".clist").show();
//                 }
//                 else
//                 {
                	$(".foodtype").removeClass("cur");
                	$(this).addClass("cur");
                	$(".clist").hide();
                	$(".f_"+type).show();
//                 }
            });
        </script>
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