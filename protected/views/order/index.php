		<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&language=en-US"></script>
        <script src="js/jquery.geocomplete.js"></script>
		<div class='ad'><img height='141' width='100%' src="/img/ad.jpg"></div>        
        
        <section class='CONTENT clear'>
            <div class='LEFT fl'>
            <form class="cmxform" id="payForm" method="POST" action="<?php echo Yii::app()->createUrl("/pay")?>">
                <h4 style='margin:0px 0 20px;'>选择支付方式：</h4>
                <p style='margin-bottom:20px;' id='xyk'>
                    <!-- <span class='radselect active' paytype='visa'></span> Visa &nbsp;&nbsp;&nbsp;&nbsp;<span class='radselect' paytype='mastercard'></span> Mastercard &nbsp;&nbsp;&nbsp;&nbsp; --><span id='cash' class='radselect cash active' paytype='cash'></span> Cash <br>
                </p>
                <div class='xykbox hidden'>
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
                <h4 style='margin:40px 0 20px;'>选择联系方式：</h4>

                <div class='mcafter' style="display:<?php echo $user->mobile!=""?"":"none";?>"><span class='radselect active'></span> <span class='tel'><?php echo $user->mobile!=""?$user->mobile:"";?></span> <span class='red link' id='fconnectmody'>修改</span></div>
                <div class='mcbefore' style='display:<?php echo $user->mobile!=""?"none":"";?>'><input class='xinyka fconnect'  type='text'/> <span id='fconnectsave' class='red link'>保存</span></div>

                <script type="text/javascript">
                $('#fconnectmody').click(function(event) {
                    $('.fconnect').val($('.tel').text());
                    $('.mcbefore').show();
                    $('.mcafter').hide();
                });
                $('#fconnectsave').click(function(event) {
                	var mobile = $('.fconnect').val();
                	if(mobile == "")
                	{
                		alert("请设置电话号码!");
                		return;
                	}
                	$.ajax( {    
					    url:'<?php echo Yii::app()->createUrl("/userset/mobile"); ?>',// 跳转到 action    
					    data:{    
					             mobile:mobile,
					    },    
					    type:'post',    
					    cache:false,    
					    dataType:'json',    
					    success:function(data) {    
					        if(data.msg =="success" ){ 
					        	$('.tel').text($('.fconnect').val());
			                    $('.mcbefore').hide();
			                    $('.mcafter').show();   
					            // view("修改成功！");    
					            //alert("修改成功!");     
					        }else{    
					            alert("修改失败!");
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
                </script>

                <h4 style='margin:40px 0 20px;'>请选择您的地址：</h4>
                <?php 
                if($user->address){
                	foreach ($user->address as $value)
                	{
               ?>
               <div class='addresslist'>
                    <span class='radselect<?php echo $value->id==$user->address_id?" active":"";?>'></span> <span class='addrspan' data-id="<?php echo $value->id;?>" region="<?php echo $value->region;?>" locality="<?php echo $value->locality;?>" street="<?php echo $value->street;?>" zipcode="<?php echo $value->zipcode;?>"><?php echo $value->address;?></span> <img class='remove' src="/img/jian.png"> <img class='add' src="/img/jia.png">
                </div>
               <?php
                	}
                }else{
                ?>
                <div class='addresslist'>
                <a class='add red link'>添加</a>
                </div>
                <?php }?>
                
                <div id='addad' style='display:none'>
                	<input type="hidden" id="format_address">
                    <input id="geocomplete" format-address="" style='width:600px;' class='pinfo' type="text" autocomplete="off" maxlength="100"/> <span id='addbtnok' class='red link'>确定</span>
                	<div id="addrinfo" class="addrinfo"></div>
                </div>
                <span id='savebtnok' class='red link' style='display:none'>保存修改</span>
                
                <ul class='addetail' style="display:none">
                    <li>Location: <span data-geo="location"></span></li>
                    <li>Route: <span data-geo="route"></span></li>
                    <li>Street Number: <span data-geo="street_number"></span></li>
                    <li>Postal Code: <span data-geo="postal_code"></span></li>
                    <li>Locality: <span data-geo="locality"></span></li>
                    <li>Country Code: <span data-geo="country_short"></span></li>
                    <li>State: <span data-geo="administrative_area_level_1"></span></li>
                </ul>

                <script type="text/javascript">
                
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
					$('#savebtnok').fadeIn();
                });

                $(document).on('click','.add',function(){
                     $('#addad').fadeIn();
                     $('#savebtnok').fadeIn();
                });
                $('#addbtnok').click(function(){
                    var v = $('#geocomplete').val();
                    if(v == "")
                    {
                    	return false;
                    }
                    $("#geocomplete").geocomplete("mygeocode",v,function(result,status){
                    	var address = formatAddress(result[0]['address_components']);
                    	if(!address.postal_code || address.postal_code == "")
                        {
    						alert("请填写正确的地址!");
    						return false;
                        }
                        var street = (address.subpremise?address.subpremise+"/":"")+(address.street_number?address.street_number+" ":"")+(address.route?address.route:"");
                        var locality = address.locality?address.locality:"";
                        var region = address.administrative_area_level_1?address.administrative_area_level_1:"";
                        var zipcode = address.postal_code?address.postal_code:"";
                    	$('.addresslist:last').after("<div class='addresslist'><span class='radselect'></span> <span class='addrspan' street='"+street+"' locality='"+locality+"' region='"+region+"' zipcode='"+zipcode+"' data-id='0'>"+v+"</span> <img class='remove' src='img/jian.png'> <img class='add' src='img/jia.png'></div>");
                    });
                });
				 $('#savebtnok').click(function(){
				 	var address = new Array();
				 	var address_default = false;
				 	$(".addrspan").each(function(){
				 		if($(this).prev().hasClass('active'))
				 		{
				 			address_default = true;
				 			address.push({id:$(this).attr('data-id'),'value':$(this).html(),'default':1,street:$(this).attr('street'),locality:$(this).attr('locality'),region:$(this).attr('region'),zipcode:$(this).attr('zipcode')});
				 		}
				 		else
				 		{
				 			address.push({id:$(this).attr('data-id'),'value':$(this).html(),'default':0,street:$(this).attr('street'),locality:$(this).attr('locality'),region:$(this).attr('region'),zipcode:$(this).attr('zipcode')});
				 		}
				 	});
				 	if(!address_default)
  				 	{
  				 		tips('.addressinfo','亲，请选择一个默认地址!');
						return false;
 	  	  			}
					//return;
				 	$.ajax( {    
					    url:'<?php echo Yii::app()->createUrl("/userset/address"); ?>',// 跳转到 action    
					    data:{    
					        address:address,
					    },    
					    type:'post',    
					    cache:false,    
					    dataType:'json',    
					    success:function(data) {    
					        if(data.msg =="success" ){
					        	 $('#addad').fadeOut();
					        	 $('#savebtnok').fadeOut();
					            // view("修改成功！");    
					            //alert("修改成功!");     
					        }else{    
					            alert("添加失败!");
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
                <button class='paysubmit2' id='paysubmit2' type='submit'>我要买单</button> <small class='tip red'>亲，在付款之前请仔细确认您的电话地址呦！</small>
            </form>
            </div>
            <script>
            //付款信息表单验证
            $('#paysubmit2').click(function(e) {
                var pass=true;
                $('.valiclass').remove();
                e.preventDefault();
                //console.log($('.cash').hasClass('active'));
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
                var ftel = $.trim($('.tel').text());
                if(ftel==''){
                        tips('#fconnectmody','电话号码不能为空哦~');
                        pass=false;
                    }else{
                        tips('#fconnectmody');
                }
                var fadress = $('.addresslist .active').next().text();
                var zipcode = $('.addresslist .active').next().attr("zipcode");
				var postarea = '<?php echo $restaurant->area;?>';
				if(postarea.indexOf(","+zipcode+",")<0)
				{
					alert("对不起,您的地址不在该餐厅送餐区域内!\n餐厅送餐区号为:(<?php echo trim($restaurant->area,",");?>).");
					return false;
				}
                if(pass){
                	$("#user_mobile").val(ftel);
                	$("#user_address").val(fadress);
                	$("#pay_type").val(paytype);
                	$("#payForm").submit();
                    //alert([paytype,fname,fnum,fyear,fmonth,fthree,ftel,fadress]);
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
            //单选
            $(document).on('click','.radselect',function(){
                $(this).parent().find('.radselect').removeClass('active');
                $(this).addClass('active');
            });
            $(document).on('click','.addresslist .radselect',function(){
                $('.addresslist .radselect').removeClass('active');
                $(this).addClass('active');
                $('#savebtnok').fadeIn();
            });
            $("#geocomplete").change(function(){
					$(this).attr("format-address",$(this).val());
            });
            //地址自动补全
            $(function(){
            //return;
            var options = {
              map: "",
              details: ".addetail",
              detailsAttribute: "data-geo",
//               blur : true,
//               geocodeAfterResult: true,
//            	  restoreValueAfterBlur: true,
              country: 'AU'
            }
            $("#geocomplete").geocomplete(options)
              .bind("geocode:result", function(event, result){
            		$("#addrinfo").html(result.adr_address);
                	$("#format_address").val(result.formatted_address);
              })
              .bind("geocode:myresult", function(event, result){
                //console.log(result);
              })
              .bind("geocode:error", function(event, status){
                console.log("ERROR: " + status);
              })
              .bind("geocode:multiple", function(event, results){
                //console.log('multi',results);
//                 $.log("Multiple: " + results.length + " results found");
              });            
          });
         </script>