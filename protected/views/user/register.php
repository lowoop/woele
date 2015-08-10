<script src="http://maps.googleapis.com/maps/api/js?sensor=false&language=en-US&amp;libraries=places"></script>
<script src="js/jquery.geocomplete.js"></script>
		<div class='ad'><img height='141' width='100%' src="img/ad.jpg"></div>        
        
        <section class='CONTENT clear'>
            <div class='LEFT fl'>
                <h1 style='margin:0px 0 30px;font-size:25px;'>即刻注册，尽享美食到家!</h1>
                <div class='pinfobox enter'>
                    <input class='pinfo pusername' placeholder='输入用户名' type='text'/><br>
                    <input class='pinfo prealname' placeholder='输入您的姓名' type='text'/><br>
                    <input class='pinfo pmobile' placeholder='输入手机号码' type='text'/><br>
                    <input class='pinfo pemail' placeholder='输入邮箱账号' type='text'/><br>
                    <input id="geocomplete" street="" locality="" region="" zipcode="" autocomplete="off" class='pinfo paddress' placeholder='输入您送餐地址' type='text'/><br>
                    <div id="addrinfo" class="addrinfo"></div>
                    <input type="hidden" id="format_address">
                    <input class='pinfo ppassword' placeholder='输入您的密码' type='password'/><br>
                    <input class='pinfo ppassword1' placeholder='确认您的密码' type='password'/><br>
                    <button class="paysubmit2 okbtn enterkey" style="margin:20px 50px 0 70px;" id='paysubmit1'>确认</button>
                    <button class="paysubmit2 okbtn">返回</button>
                </div>
                <script>
                //个人信息验证
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

                    var pmobile = $('.pmobile').val();
                    pmobile = $.trim(pmobile);
                    if(pmobile==''){
                        tips('.pmobile','亲，电话号码不能为空哦~');
                        pass=false;
                    }else{
                        tips('.pmobile');
                    }

                    var pemail = $('.pemail').val();
                    if(!email(pemail)){
                        tips('.pemail','亲，邮箱格式错误~');
                        pass=false;
                    }else{
                        tips('.pemail');
                    }

                    var paddress = $('.paddress').val();
                    if($.trim(paddress)==''){
                        tips('.paddress','亲，请填写正确的地址~');
                        pass=false;
                    }else{
                        tips('.paddress');
                    }

                    var ppassword = $('.ppassword').val();
                    var ppassword1 = $('.ppassword1').val();
                     if((ppassword!=ppassword1)||(ppassword=='')){
                        tips('.ppassword1',' 亲，两次输入密码不一致哦~');
                        pass=false;
                    }else{
                        tips('.ppassword1');tips('.ppassword');
                    }

                    
                                
                var fadress = $('.addresslist .active').parent().text();
                if(pass)
                {
                    var v = $("#geocomplete").val();
	                $("#geocomplete").geocomplete("mygeocode",v,function(result,status){
                        $('.pinfobox .valiclass').remove();
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
	                    $.ajax({
							url : "<?php echo Yii::app()->createUrl("/user/register");?>",
							data : {
								username : pusername,
								realname : prealname,
								mobile : pmobile,
								email : pemail,
								password : ppassword,
								address : paddress,
								street : street,
								locality : locality,
								region : region,
								zipcode : zipcode,
							},
							type : "post",
							dataType : "json",
							success : function(res){
								if(res.msg=="success")
								{
									window.location.href = "<?php echo Yii::app()->createUrl("/login");?>";
									return false; 
								}
								else
								{
									$('.pinfobox .valiclass').remove();
						        	var errors = res.errors;  
						            for(var id in errors)
						            {
						            	tips('.p'+id,errors[id][0]);
								    }
						            return false; 
								}
							},
							error : function(res){
								alert("异常！"); 
						          return false; 
							},
	                    });
		            });
                }
            });
                
                </script>
                <div style="display: none;">
                <h4 style='margin:40px 0 20px;'>输入您的地址：</h4>
                <div class='addresslist'>
                    <span class='radselect active'></span> 北京市海淀区北四环西路58号理想国际大厦 <img class='remove' src="img/jian.png"> <img class='add' src="img/jia.png">
                </div>
                <div id='addad' style='display:none'>
                    <input id="geocomplete"  style='width:600px;'  class='pinfo' type="text" autocomplete="off" maxlength="100"/> <span id='addbtnok' class='red'>确定</span>
                </div>
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
                <button class='paysubmit2 okbtn' style='margin:0 50px 0 138px;'>确认</button><button class='paysubmit2 okbtn'>返回</button>
            	</div>
            </div>
            <div class="RIGHT fr">
                <div id="tofix">
                    <a href=""><img src="img/pic4.jpg"></a>
                </div>
            </div>
            </div>
        </section>
        <script type="text/javascript">
            //单选
        
            $(document).on('click','.radselect',function(){
                $(this).parent().find('.radselect').removeClass('active');
                $(this).addClass('active');
            });
            $(document).on('click','.addresslist .radselect',function(){
                $('.addresslist .radselect').removeClass('active');
                $(this).addClass('active');
            });
            $(function(){
	            var options = {
	                    map: false,
	                    details: ".addetail",
	                    detailsAttribute: "data-geo",
// 	                    autoselect: false,
// 	                    blur: true,
// 	                    geocodeAfterResult: true,
// 	                    restoreValueAfterBlur: true,
	                    country: 'AU'
	                 };
	            $("#geocomplete").geocomplete(options)
	                .bind("geocode:result", function(event, result){
	                	
// 	                     console.log(result);
	                     $("#addrinfo").html(result.adr_address);
	                  	 $("#format_address").val(result.formatted_address);
	                })
	                .bind("geocode:error", function(event, status){
	                     console.log("ERROR: " + status);
	                 })
	                 .bind("geocode:multiple", function(event, results){
	                   //console.log('multi',results);
// 	                 $.log("Multiple: " + results.length + " results found");
	             });
            });
            
        </script>