		<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&language=en-US"></script>
        <script src="js/jquery.geocomplete.js"></script>
		<div class='ad'><img height='141' width='100%' src="/img/ad.jpg"></div>        
        
        <section class='CONTENT clear'>
            <div class='LEFT fl'>
                <h4 class='red' style='margin:0 0 25px;'>您还未注册或登陆，请填写您的信息</h4>
                <h4 style='margin:0 0 20px;'>填写个人信息</h4>
                <div class='pinfobox enter'>
                    <input class='pinfo pusername' placeholder='输入用户名' type='text'/><br>
                    <input class='pinfo prealname' placeholder='输入您的姓名' type='text'/><br>
                    <input class='pinfo pmobile' placeholder='输入手机号码' type='text'/><br>
                    <input class='pinfo pemail' placeholder='输入邮箱账号' type='text'/><br>
                    <input id="geocomplete" street="" locality="" region="" zipcode="" autocomplete="off" class='pinfo paddress' placeholder='输入您送餐地址' type='text'/><br>
                    <input class='pinfo password' placeholder='输入您的密码' type='password'/><br>
                    <input class='pinfo password1' placeholder='确认您的密码' type='password'/><br>
                    <button class='paysubmit enterkey' id='paysubmit1'>确认信息</button>
                    <span class="pinfo errorinfo"></span>
                </div>
                <script>
                //个人信息验证
                var isregister = false;
                $('#paysubmit1').click(function(e) {
                    var pass=true;
                    $('.pinfobox .valiclass').remove();
                    e.preventDefault();
                    var paytype = $('#xyk .active').attr('paytype');

                    var pusername = $('.pusername').val();
                    if($.trim(pusername)==''){
                        tips('.pusername','亲，用户名不能为空哦~');
                        pass=false;
                    }else{
                        tips('.pusername');
                    }
                    
                    var prealname = $('.prealname').val();
                    if($.trim(prealname)==''){
                        tips('.prealname','亲，姓名不能为空哦~');
                        pass=false;
                    }else{
                        tips('.prealname');
                    }

                    var paddress = $('.paddress').val();
                    if($.trim(paddress)==''){
                        tips('.paddress','亲，地址不能为空哦~');
                        pass=false;
                    }else{
                    	$("#user_address").val(paddress);
                        tips('.paddress');
                    }

                    var pmobile = $('.pmobile').val();
                    pmobile = $.trim(pmobile);
                    if(pmobile==''){
                        tips('.pmobile','亲，电话号码不能为空哦~');
                        pass=false;
                    }else{
                        $("#user_mobile").val(pmobile);
                        tips('.pmobile');
                    }

                    var pemail = $('.pemail').val();
                    if(!email(pemail)){
                        tips('.pemail','亲，邮箱格式错误~');
                        pass=false;
                    }else{
                        tips('.pemail');
                    }

                    var password = $('.password').val();
                    var password1 = $('.password1').val();
                     if((password!=password1)||(password=='')){
                        tips('.password1',' 亲，两次输入密码不一致哦~');
                        pass=false;
                    }else{
                        tips('.password');tips('.password1');
                    }

                    
                                
                var fadress = $('.addresslist .active').parent().text();
                if(pass)
                {
                	var v = $("#geocomplete").val();
	                $("#geocomplete").geocomplete("mygeocode",v,function(result,status){
	                	if(result.length!=1)
	                	{
	                		tips('#geocomplete','亲，请填写详细地址~');
							return false;
	                    }
	                	var address = formatAddress(result[0]['address_components']);
	                	if(!address.postal_code || address.postal_code == "")
	                    {
	                		tips('#geocomplete','亲，请填写正确地址~');
							return false;
	                    }
	                    var street = (address.subpremise?address.subpremise+"/":"")+(address.street_number?address.street_number+" ":"")+(address.route?address.route:"");
	                    var locality = address.locality?address.locality:"";
	                    var region = address.administrative_area_level_1?address.administrative_area_level_1:"";
	                    var zipcode = address.postal_code?address.postal_code:"";
	                    var postarea = '<?php echo $restaurant->area;?>';
	    				if(postarea.indexOf(","+zipcode+",")<0)
	    				{
	    					alert("对不起,您的地址不在该餐厅送餐区域内!\n餐厅送餐区号为:(<?php echo trim($restaurant->area,",");?>).");
	    					return false;
	    				}
	                    $.ajax( {    
						    url:'<?php echo Yii::app()->createUrl("/user/registerajax"); ?>',// 跳转到 action    
						    data:{    
						    	username : pusername,
						    	realname : prealname,
						    	address : paddress,
						    	mobile : pmobile,
						    	email : pemail,
						    	password : password,
						    	street : street,
								locality : locality,
								region : region,
								zipcode : zipcode,
						    },    
						    type:'post',    
						    cache:false,    
						    dataType:'json',    
						    success:function(data) {    
						        if(data.msg =="success" ){
							        tips(".errorinfo","用户注册成功!");
							        isregister = true;
						            // view("修改成功！");    
//	 					            alert("修改成功!");     
						        }else{ 
						        	$('.pinfobox .valiclass').remove();
						        	var errors = data.errors;  
						            for(var id in errors)
						            {
						            	tips('.p'+id,errors[id][0]);
								    }
						            return false; 
						        }    
						     },    
						     error : function() {    
						          // view("异常！");    
						          alert("异常！"); 
						          return false;   
						     }    
						});
	                });
                }

                if(pass){
                	 
                }
            });
                
                </script>
                <form class="cmxform" id="payForm" method="POST" action="<?php echo Yii::app()->createUrl("/pay")?>">
                <h4 style='margin:40px 0 20px;'>选择支付方式：</h4>
                 <p style='margin-bottom:20px;' id='xyk'>
                    <span class='radselect active' paytype='visa'></span> Visa &nbsp;&nbsp;&nbsp;&nbsp;<span class='radselect' paytype='mastercard'></span> Mastercard &nbsp;&nbsp;&nbsp;&nbsp;<span id='cash' class='radselect cash' paytype='cash'></span> Cash <br>
                </p>
                <div class='xykbox'>
                    *信用卡姓名：<input class='xinyka fname' type='text' name="cardowner"/> <br>
                    *信用卡卡号：<input class='xinyka fnum' type='text' name="cardnum"/><br>
                    *过期日期号：
                    <select class='payselect' id='fyear' name="year">
                        <option value ="年份">年份</option>
                        <option value ="2015">2015</option>
                        <option value ="2016">2016</option>
                        <option value ="2017">2017</option>
                        <option value ="2018">2018</option>
                        <option value ="2019">2019</option>
                        <option value ="2020">2020</option>
                        <option value ="2021">2021</option>
                        <option value ="2022">2022</option>
                    </select>   /   
                    <select class='payselect' id='fmonth' name="month">
                        <option value ="月份">月份</option>
                        <option value ="01">01</option>
                        <option value ="02">02</option>
                        <option value ="03">03</option>
                        <option value ="04">04</option>
                        <option value ="05">05</option>
                        <option value ="06">06</option>
                        <option value ="07">07</option>
                        <option value ="08">08</option>
                        <option value ="09">09</option>
                        <option value ="10">10</option>
                        <option value ="11">11</option>
                        <option value ="12">12</option>
                    </select> 
                    <br>
                    *卡后三位数：<input class='xinyka fthree'  type='text' name="num"/>
                </div>
                <script type="text/javascript">
                    //付款选项卡
                    $('#xyk span').click(function(event) {
                        if($(this).hasClass('cash')){
                            $('.xykbox').hide();
                        }else{
                            $('.xykbox').show();
                        }
                    });
                </script>
                
                <script type="text/javascript">
                //添加地址
                $(document).on('click','.remove',function(){
                    if($('.addresslist').size()==1){
                        tips('.addresslist','亲，地址必填哦!');
                        setTimeout(function(){
                            $('.valiclass').fadeOut(function(){
                                $(this).remove();
                            });
                        },500);
                        return;
                    }
                    $(this).parent().remove();

                });

                $(document).on('click','.add',function(){
                     $('#addad').fadeIn();
                });

                $('#addbtnok').click(function(){
                    var v = $('#geocomplete').val();
                    $('.addresslist:last').after("<div class='addresslist'><span class='radselect'></span> "+v+" <img class='remove' src='img/jian.png'> <img class='add' src='img/jia.png'></div>");
                });

                </script>
                <input type="hidden" value="<?php echo urlencode(base64_encode(implode(",",$order['food'])));?>" name="food">
                <input type="hidden" value="<?php echo urlencode(base64_encode($order['date']));?>" name="date">
                <input type="hidden" value="<?php echo urlencode(base64_encode($order['time']));?>" name="time">
                <input type="hidden" value="" name="mobile" id="user_mobile">
                <input type="hidden" value="" name="address" id="user_address">
                <input type="hidden" value="visa" name="type" id="pay_type">
                <input type="hidden" value="<?php echo $restaurant->id;?>" name="rid">
                <input type="hidden" value="<?php echo $price;?>" name="price">
                <b style='padding:30px 0 20px;display:block' class='red f24'>总计：$<?php echo $price;?></b>
                <button class='paysubmit2' id='paysubmit2'>我要买单</button> <small class='tip red'>亲，在付款之前请仔细确认您的电话地址呦！</small>
            </div>
            </form>
            <script>
            //付款信息表单验证
            $('#paysubmit2').click(function(e) {
                if(!isregister)
                {
					alert("用户未注册!");
					return false;
                }
                var pass=true;
                $('.xykbox .valiclass').remove();
                e.preventDefault();
                var paytype = $('#xyk .active').attr('paytype');
                if(!$('.cash').hasClass('active')){
                    var fname = $('.fname').val();
                    if($.trim(fname)==''){
                        tips('.fname','亲，信用卡姓名不能为空哦~');
                        pass=false;
                    }else{
                        tips('.fname');
                    }

                    var fnum = $('.fnum').val();
                    if(!numeric(fnum)){
                        tips('.fnum','亲，信用卡必须全部为数字哦~');
                        pass=false;
                    }else{
                        tips('.fnum');
                    }

                    var fyear = $('#fyear').val();
                    var fmonth = $('#fmonth').val();
                     if(fyear=='年份'||fmonth=='月份'){
                        tips('#fmonth',' 亲，过期日期填写完整哦~');
                        pass=false;
                    }else{
                        tips('#fmonth');
                    }

                    var fthree = $('.fthree').val();
                    if(!numeric3(fthree)){
                        tips('.fthree','亲，卡后三位数为3位数字哦~');
                        pass=false;
                    }else{
                        tips('.fthree');
                    }
                }
                
//                 var fadress = $('.addresslist .active').parent().text();

                if(pass){
                	$("#pay_type").val(paytype);
                	$("#payForm").submit();
//                     alert([paytype,fname,fnum,fyear,fmonth,fthree,fadress]);
                }
            });

            
            </script>
            <div class="RIGHT fr">
                <div id="tofix">
                <div class="rordertt">我的订单</div>
                <div class='mycase'>
                    <div class="hisransd">
                        <a href=""><img class="fl" src="/img/upload/<?php echo $restaurant->image;?>"></a>
                        <h3><a href=""><?php echo $restaurant->name;?></a></h3>
                        <p>
                            地址：<?php echo $restaurant->address;?><br>
                        </p>
                    </div>
                    <table>
                        <tbody>
                        <?php foreach ($foods as $value){?>
                         <tr>
                            <td><?php echo $value['name'];?></td><td>x<?php echo $value['num'];?></td><td align="right">$<?php echo $value['price'];?></td>
                        </tr>
                        <?php }?>
                        <tr>
                            <td>送餐费</td><td></td><td align="right">$<?php echo JConfig::getFee()."-".$discount;?></td>
                        </tr>
                        <tr>
                            <td>送餐时间</td><td><?php echo $order['date'];?></td><td align="right"><?php echo $order['time'];?></td>
                        </tr>
                        <tr>
                            <td colspan="2" ><span class='red'>总计</span></td><td align="right"><span class='red'>$<?php echo $price;?></span></td>
                        </tr>
                    </tbody></table>
                </div>
            </div>
            </div>
        </section>
        <script type="text/javascript">
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
            $(function(){
            	//单选
                $(document).on('click','.radselect',function(){
                    $(this).parent().find('.radselect').removeClass('active');
                    $(this).addClass('active');
                });
                $(document).on('click','.addresslist .radselect',function(){
                    $('.addresslist .radselect').removeClass('active');
                    $(this).addClass('active');
                }); 
                var options = {
                    map: "",
                    details: ".addetail",
                    detailsAttribute: "data-geo",
                    country: 'AU'
                 }
                 $("#geocomplete").geocomplete(options)
                     .bind("geocode:result", function(event, result){
                          console.log("Result: " + result.formatted_address);
                     })
                     .bind("geocode:error", function(event, status){
                          console.log("ERROR: " + status);
                      })
                      .bind("geocode:multiple", function(event, results){
                        //console.log('multi',results);
                      $.log("Multiple: " + results.length + " results found");
                  });
            });
        </script>