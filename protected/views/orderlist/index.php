		<div class='ad'><img height='141' width='100%' src="/img/ad.jpg"></div>        
        
        <section class='CONTENT clear'>
            <div class='LEFT fl history'>
               <h1>全部历史订单</h1>
               <?php
               foreach ($data as $value)
               {
               	?>
               	<div class='box'>
                    <span class='circle'></span><?php echo date("Y-m-d H:i:s",$value->create_datetime);?><i>|</i>单号：<?php echo $value->onum;?><i>|</i><?php echo Order::getStatus($value->status);?><br>
                    <div class='hisransd'>
                        <a href="<?php echo Yii::app()->createUrl("/restaurant?id=".$value->restaurant->id);?>"><img class='fl' src="/img/upload/<?php echo $value->restaurant->image;?>"></a>
                        <h3><a href="<?php echo Yii::app()->createUrl("/restaurant?id=".$value->restaurant->id);?>"><?php echo $value->restaurant->name;?></a></h3>
                        <p>
                            地址：<?php echo $value->restaurant->address;?><br>
                            电话：<?php echo $value->restaurant->tel;?><br>
                            营业时间：<?php echo $value->restaurant->open_time;?>-<?php echo $value->restaurant->close_time;?><br>
                        </p>
                    </div>
                    <table>
                    	<?php
                    	foreach ($value->po as $v)
                    	{
                    	?>
                    	<tr>
                            <td><?php echo $v->food->name;?></td><td>x<?php echo $v->num;?></td><td align='right'>$<?php echo $v->price;?></td>
                        </tr>
                    	<?php
                    	}
                    	?>
                        <tr>
                            <td>送餐费</td><td></td><td align='right'>$<?php echo $value->fee;?></td>
                        </tr>
                        <tr>
                            <td colspan='2'>总计</td><td align='right'>$<?php echo $value->total_price;?></td>
                        </tr>
                        <?php
                        if($value->status == 4)
                        {
                            ?>
                            <tr>
                                <td colspan='3'>送餐时间(<?php echo date("H:i:s",$value->send_datetime);?>)</td>
                            </tr>
                        <?php
                        }
                        ?>

                    </table>
                </div>
               	<?php
               }
               
               ?>
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
            </div>
	        	 
            <div class='RIGHT fr'>
                <a href=""><img src="/img/pic4.jpg"></a>
            </div>
        </section>