		<div class='ad'><img height='141' width='100%' src="/img/ad.jpg"></div>        
        
        <section class='listcontent clear'>
            <div class='left'>
                <div class='searchbox'>
                    <input placeholder='请输入餐厅名' type='text' id='keyword' value="<?php echo $params['keyword'];?>"/>
                    <span id='search'></span>
                </div>
                <?php
                    $parent_tag = "";
                    foreach ($tags as $key=>$value)
                    {
                        $parent_tag .= " tag".$key;
                ?>
                <div class='cptt'><?php echo $value['name'];?>选择:</div>
                <div class='cp clear'>
                <?php foreach ($value['value'] as $k=>$v){?>
                <span onclick="showTag(<?php echo $key;?>,<?php echo $k;?>,this)"><?php echo $v;?></span>
                <?php }?>
                </div>
                <?php }?>
                <div class='clbtn'>清除选择</div>
            </div>
            <div class='right'>
                <div class='shopstop'><span class="radselect"></span> 显示未营业餐厅</div>
                <ul>
                <?php if(isset($restaurant['open'])){?>
                <?php foreach ($restaurant['open'] as $value){?>
                <li class="<?php echo str_replace(array(",",":"), array(" tag","_"), $value['tags']);?>">
                		<?php if($value['vip'] == 1){?>
                        <div class='vip'></div>
                        <?php }?>
                        <a href='<?php echo Yii::app()->createUrl("/restaurant")."?id=".$value['id'];?>' class='img'><img src="/img/upload/<?php echo $value['image'];?>"></a>
                        <span class='fr'>起送价：<?php echo $value['start'];?>$</span><a href='<?php echo Yii::app()->createUrl("/restaurant")."?id=".$value['id'];?>'><?php echo $value['name'];?></a>
                        <div class='juan'>
                            <?php
                            if(trim($value['labels'],",") != "") {
                                $arr_label = explode(",", trim($value['labels'], ","));
                                foreach ($arr_label as $lable) {
                                    ?>
                                    <i class='col0<?php echo $lable;?>'><?php echo JConfig::item("config.label." . $lable);?></i>
                                <?php
                                }
                            }
                            ?>
                        </div>
                </li>
                <?php }?>
                <?php }?>
                </ul>

                <ul class='stopdiv'>
                <?php if(isset($restaurant['close'])){?>
                <?php foreach ($restaurant['close'] as $value){?>
                	<li class='opacity <?php echo str_replace(array(",",":"), array(" tag","_"), $value['tags']);?>'>
                		<?php if($value['vip'] == 1){?>
                        <div class='vip'></div>
                        <?php }?>
                        <a href='<?php echo Yii::app()->createUrl("/restaurant")."?id=".$value['id'];?>' class='img'><img src="/img/upload/<?php echo $value['image'];?>"></a>
                        <span class='fr'>起送价：<?php echo $value['start'];?>$</span><a href='<?php echo Yii::app()->createUrl("/restaurant")."?id=".$value['id'];?>'><?php echo $value['name'];?></a>
                        <div class='juan'>
                            <?php
                                if(trim($value['labels'],",") != "") {
                                    $arr_label = explode(",", trim($value['labels'], ","));
                                    foreach ($arr_label as $lable) {
                                        ?>
                                        <i class='col0<?php echo $lable;?>'><?php echo JConfig::item("config.label." . $lable);?></i>
                                    <?php
                                    }
                                }
                            ?>
                        </div>
                    </li>
                <?php }?>
                <?php }?>
                </ul>
            </div>
        </section>
        <script>
		$(function(){
			var openCount = <?php echo isset($restaurant['open'])?count($restaurant['open']):0;?>;
			if(openCount<1)
			{
				$('.radselect').click();
			}
		});
		function getS(id)
		{
			window.location.href = "";
		}
		var bucket = {};
		/*function showTag(tag,value,obj)
		{

			bucket[tag] = value;
// 			console.log(bucket);
			$(".tag").css("display","none");
			if($(obj).hasClass("cur"))
			{
				delete bucket[tag];
				$(".tag"+tag).css("display","");
			}
			var tagClass = "";
			for(var i in bucket)
			{
				tagClass += ".ztag"+bucket[i];
			}
			$(tagClass).css("display","");
		}*/
        function showTag(tag,value,obj)
        {
            if($(obj).hasClass("cur"))
            {
                delete bucket[tag];
            }
            else
            {
                bucket[tag] = value;
            }

            if(bucket.length == 0)
            {
                $(".tag").css("display","");
            }
            else
            {
                $(".tag").css("display","none");
            }

            $(".tag").each(function(){
                var thisTag = $(this);
                var show = true;
                $.each(bucket,function(key,val){
                    if(!thisTag.hasClass("tag"+key+"_"+val))
                    {
                        show = false;
                    }
                });
                if(show)
                {
                    thisTag.show();
                }
            });
            console.log(bucket);
        }
		$("#search").click(function(){
			var keyword = $("#keyword").val();
			<?php unset($params['keyword']);?>
			var url = '<?php echo http_build_query($params);?>';
			if(keyword!="")
			{
				if(url == "")
				{
					url = "keyword="+keyword;
				}
				else
				{
					url += "&keyword="+keyword;
				}
			}
			window.location.href = '<?php echo Yii::app()->createUrl("/search");?>?'+url;
		});
		$(".listcontent .left .clbtn").click(function(event) {
			bucket = {};
            $('.listcontent .left .cp span').removeClass('cur');
            $(".tag").css("display","");
    	});
        </script>