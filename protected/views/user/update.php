		<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&language=en-US"></script>
        <script src="js/jquery.geocomplete.js"></script>
		<div class='ad'><img height='141' width='100%' src="/img/ad.jpg"></div>        
        
        <section class='CONTENT clear'>
            <div class='LEFT fl'>
                <h4 style='margin:0px 0 30px;font-size:25px;'>欢迎，你好<?php echo $model->username;?></h4>
                <h4 style='margin:20px 0 10px;'>姓名：</h4>
                <input class='xinyka prealname'  type='text' value="<?php echo $model->realname;?>"/> 
                <h4 style='margin:20px 0 10px;'>电话：</h4>
                <input class='xinyka pmobile' type='text' value="<?php echo $model->mobile;?>"/><br>
                <h4 style='margin:20px 0 10px;'>邮箱：</h4>
                <input class='xinyka pemail' type='text' value="<?php echo $model->email;?>"/><br>
                <?php if($model->source == ""){?>
                <h4 style='margin:20px 0 10px;'>修改密码：</h4>
                <input class='xinyka poldpassword' placeholder='原始密码' type='password'/><br>
                <input class='xinyka ppassword' placeholder='输入密码' type='password'/><br>
                <input class='xinyka ppassword1' placeholder='再次输入密码' type='password'/>
                <?php }?>
                

                <h4 style='margin:40px 0 20px;'>常用地址：</h4>
                <span class="addressinfo"></span>
                <?php 
                if($model->address){
                	foreach ($model->address as $value)
                	{
               	?>
               	<div class='addresslist'>
                    <span class='radselect<?php echo $value->id==$model->address_id?" active":"";?>'></span> <span class='addrspan' data-id="<?php echo $value->id;?>" region="<?php echo $value->region;?>" locality="<?php echo $value->locality;?>" street="<?php echo $value->street;?>" zipcode="<?php echo $value->zipcode;?>"><?php echo $value->address;?></span> <img class='remove' src="/img/jian.png"> <img class='add' src="/img/jia.png">
                </div>
               	<?php
                	}
                }else{
                ?>
                <div class='addresslist'>
                <a class='add'>添加</a>
                </div>
                <?php }?>
                <div id='addad' style='display:none'>
                    <input id="geocomplete"  style='width:600px;'  class='pinfo' type="text" autocomplete="off" maxlength="100"/> <span id='addbtnok' class='red'>确定</span>
                    <div id="addrinfo" class="addrinfo"></div>
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
	                 if(v == "")
	                 {
	                 	return false;
	                 }
	                 $("#geocomplete").geocomplete("mygeocode",v,function(result,status){
	                 	var address = formatAddress(result[0]['address_components']);
	                 	console.log(address);
	                 	if(!address.postal_code || address.postal_code == "")
	                     {
	 						alert("请选择正确的地址!");
	 						return false;
	                     }
	                     var street = (address.subpremise?address.subpremise+"/":"")+(address.street_number?address.street_number+" ":"")+(address.route?address.route:"");
	                     var locality = address.locality?address.locality:"";
	                     var region = address.administrative_area_level_1?address.administrative_area_level_1:"";
	                     var zipcode = address.postal_code?address.postal_code:"";
	                 	$('.addresslist:last').after("<div class='addresslist'><span class='radselect'></span> <span class='addrspan' street='"+street+"' locality='"+locality+"' region='"+region+"' zipcode='"+zipcode+"' data-id='0'>"+v+"</span> <img class='remove' src='img/jian.png'> <img class='add' src='img/jia.png'></div>");
	                 });
                });

                </script>
                
                <button class='paysubmit2' id='paysubmit1'>更新信息</button>
            </div>
            <script>
                //个人信息验证
                $('#paysubmit1').click(function(e) {
                    var pass=true;
                    $('.valiclass').remove();
                    e.preventDefault();
                    var paytype = $('#xyk .active').attr('paytype');
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
					<?php if($model->source==""){?>
                    var oldpassword = $('.poldpassword').val();
                    var password = $('.ppassword').val();
                    var password1 = $('.ppassword1').val();
                    if(password!="" || password1 != "")
                    {
	                    if((password!=""||password1!="")&&oldpassword=="")
	                    {
	                    	tips('.poldpassword',' 亲，请输入原始密码~');
	                        pass=false;
	                    }
	                    else
	                    {
	                    	tips('.poldpassword');
	                    }
	                    if((password!=password1)||(password=='')){
	                        tips('.ppassword1',' 亲，两次输入密码不一致哦~');
	                        pass=false;
	                    }else{
	                        tips('.ppassword1');tips('.ppassword');
	                    }
                    }    
                    <?php }else{?>  
                    var oldpassword = "";
                    var password = "";
                    var password1 = "";
                    <?php }?>
                    var address = new Array();
                    var address_default = false;
  				 	$(".addrspan").each(function(){
  				 		if($(this).prev().hasClass('active'))
  				 		{
  				 			address_default = true;
  				 			address.push({'value':$(this).html(),'default':1,'id':$(this).attr("data-id"),street:$(this).attr('street'),locality:$(this).attr('locality'),region:$(this).attr('region'),zipcode:$(this).attr('zipcode')});
  				 		}
  				 		else
  				 		{
  				 			address.push({'value':$(this).html(),'default':0,'id':$(this).attr("data-id"),street:$(this).attr('street'),locality:$(this).attr('locality'),region:$(this).attr('region'),zipcode:$(this).attr('zipcode')});
  				 		}
  				 	});
  				 	if(!address_default)
  				 	{
  				 		tips('.addressinfo','亲，请选择一个默认地址!');
						return false;
 	  	  			}
// 					console.log(address);
                if(pass){
                    $.ajax({
						url : "<?php echo Yii::app()->createUrl("/user/update");?>",
						data : {
							realname : prealname,
							mobile : pmobile,
							email : pemail,
							password : $.md5(password),
							oldpassword : $.md5(oldpassword),
							address : address,
						},
						type : "post",
						dataType : "json",
						success : function(res){
							if(res.msg=="success")
							{
								alert("修改成功!");
								return false; 
							}
							else
							{
								$('.valiclass').remove();
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
                }
            });
                
                </script>
            <div class="RIGHT fr">
                <a href=""><img src="img/pic4.jpg"></a>
            </div>
            </div>
        </section>
        <script type="text/javascript">
            //单选
        $(function(){
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
//                     blur : true,
//                     geocodeAfterResult: true,
//                  	  restoreValueAfterBlur: true,
                    country: 'AU'
                  };
            $("#geocomplete").geocomplete(options)
            .bind("geocode:result", function(event, result){
          		$("#addrinfo").html(result.adr_address);
//               	$("#format_address").val(result.formatted_address);
            })
            .bind("geocode:myresult", function(event, result){
              //console.log(result);
            })
            .bind("geocode:error", function(event, status){
              console.log("ERROR: " + status);
            })
            .bind("geocode:multiple", function(event, results){
              //console.log('multi',results);
//               $.log("Multiple: " + results.length + " results found");
            }); 
        });
        </script>