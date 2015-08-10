	<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&language=en-US"></script>
		<div class="banner">
		<?php if(!empty($ad)){?>
		<?php 
		$i = 0;
		$li_img = "";
		$li_dot = "";
		foreach ($ad as $key=>$value)
		{
			if($i == 0)
			{
				$li_img .= '<li style="background-image: url(/img/ad/'.$key.');display:block"></li>';
				$li_dot .= '<li class="active"></li>';
			}
			else 
			{
				$li_img .= '<li style="background: url(/img/ad/'.$key.') top center"></li>';
				$li_dot .= '<li></li>';
			}
			$i++;
		}
		?>
			<ul class='ful'>
				<?php echo $li_img;?>
			</ul>
			<div class="mask">
                <div class='dots'>
                    <ul>
                        <?php echo $li_dot;?>
                    </ul>
                </div>
            </div>
		<?php }else{?>
		    <ul class='ful'>
		        <li style="background-image: url(/img/banner.jpg);display:block"></li>
		        <li style="background: url(/img/banner2.png) top center"></li>
		        <li style="background: url(/img/banner3.jpg) top center"></li>
		        <li style="background: url(/img/banner4.jpg) top center"></li>
		    </ul>
		    <div class="mask">
                <div class='dots'>
                    <ul>
                        <li class='active'></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                </div>
            </div>
            <?php }?>
		</div>
		<script type="text/javascript">
        //幻灯代码
        var cur = 0;
        var move = function(){
            cur++;
            if(cur==4){
                cur = 0;
            }
            $('.banner .ful li:eq('+cur+')').fadeIn('slow').siblings().fadeOut('slow');
            $('.banner .mask li:eq('+cur+')').addClass('active').siblings().removeClass('active');
        }
        var timer = setInterval(move,3000);
        $('.banner').hover(function() {
            clearInterval(timer);
        }, function() {
            timer = setInterval(move,3000);
        });
        $('.banner .mask li').click(function(event) {
            var n = $(this).index();
            cur=n;
            $('.banner .ful li:eq('+n+')').fadeIn('slow').siblings().fadeOut('slow');
            $('.banner .mask li:eq('+n+')').addClass('active').siblings().removeClass('active');
        });
        </script>
		
		<section class="address div">
            <?php
            if(trim($notice)!="")
            {
                ?>
                <div class='gonggao'><span class='red'>饿了么公告：</span><?php echo $notice;?></div>
            <?php
            }
            ?>
			<input id="geocomplete" class='addressipt' type="text" autocomplete="off" maxlength="100"/>
			<!--<div class='placeholeder'>请您输入地址.....</div>-->
			<button class="searchbtn">我饿了</button>
            <ul class='addetail' style='display:none'>
                <li>Location: <span data-geo="location"></span></li>
                <li>Route: <span data-geo="route"></span></li>
                <li>Street Number: <span data-geo="street_number"></span></li>
                <li>Postal Code: <span id="postal_code" data-geo="postal_code"></span></li>
                <li>Locality: <span data-geo="locality"></span></li>
                <li>Country Code: <span data-geo="country_short"></span></li>
                <li>State: <span data-geo="administrative_area_level_1"></span></li>
            </ul>
            <div class='adderssslide' style='display:none'>
                <ul>
                    <li style='color:#e43e1e'>对不起，我不能找到您的地址，请再试一次！</li>
                </ul>
            </div>
		</section>
   <script>
        //自动补全
    $(function(){
        
        var options = {
          map: "",
          details: ".addetail",
          detailsAttribute: "data-geo",
          country: 'AU'
        }
        
        $("#geocomplete").geocomplete(options)
          .bind("geocode:result", function(event, result){
              $(this).focus();
//             console.log("Result: " + result.formatted_address);
          })
          .bind("geocode:error", function(event, status){
            console.log("ERROR: " + status);
          })
          .bind("geocode:multiple", function(event, results){
            console.log('multi',results);
            $.log("Multiple: " + results.length + " results found");
          });
        
        $("#find").click(function(){
          //$("#geocomplete").trigger("geocode");
        });
        
        
      });
        </script>
		<section class="stepwp">
        	<div class="step div">
        		<h1>如何订餐?</h1>
        		<span style="width:160px;">输入你的地址</span>
        		<span style="width: 400px;">选择你喜欢的餐厅和菜品</span>
        		<span style="width: 200px;">选择付款方式</span>
        		<span style="width: 165px;text-align: right">开饭啦</span>
        	</div>
        </section>
        <script>
            //$('.banner').unslider({dots: true});

            //地址栏
            $('.address .placeholeder').click(function(){
                $(this).hide();
                //$('.addressipt').focus();
                //$('.adderssslide').show();
            });
            $('.addressipt').blur(function(){
                if($('.addressipt').val()==''){
                    $('.address .placeholeder').show();
                }
                //$('.adderssslide').hide();
            });
            $('.addressipt').focus(function(event) {
                //$('.adderssslide').show();
            });
            $('.adderssslide li').click(function(event) {
                //$('.addressipt').val($(this).text());
            });
            $(".searchbtn").click(function(){
				var code = $("#postal_code").html();
				if(code=="")
				{
					$('.adderssslide').show();
					//$('.adderssslide').fadeOut(1000);
					return false;
				}
				$('.adderssslide').fadeOut(1000);
				window.location.href="<?php echo Yii::app()->createUrl("/search");?>?code="+code;
            });
            $('#geocomplete').keydown(function(e){
    			if(e.keyCode==13){
    				$(".searchbtn").click();
    			}
    		});
        </script>
