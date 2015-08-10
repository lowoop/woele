		<div class='ad'><img height='141' width='100%' src="/img/ad.jpg"></div>        
        
        <section class='CONTENT clear'>
            <div class='LEFT fl'>
                <h4 style='margin:0px 0 30px;font-size:25px;'>欢迎，你好<?php echo $model->username;?></h4>
                <?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'user-form',
					'enableAjaxValidation'=>false,
				)); ?>
				<?php echo CHtml::errorSummary($model); ?>
                <h4 style='margin:20px 0 10px;'>名字：</h4>
                <?php echo $form->textField($model,'firstname',array('class'=>'xinyka','style'=>'width:189px;')); ?>
                <?php echo $form->textField($model,'lastname',array('class'=>'xinyka','style'=>'width:189px;')); ?>
                <h4 style='margin:20px 0 10px;'>电话：</h4>
                <?php echo $form->textField($model,'tel',array('class'=>'xinyka')); ?><br>
                <h4 style='margin:20px 0 10px;'>邮箱：</h4>
                <?php echo $form->textField($model,'email',array('class'=>'xinyka')); ?><br>
                <h4 style='margin:20px 0 10px;'>修改密码：</h4>
                <?php echo CHtml::passwordField('User[password]','',array('class'=>'xinyka','placeholder'=>'输入密码')); ?><br>
                <?php echo CHtml::passwordField('User[password1]','',array('class'=>'xinyka','placeholder'=>'再次输入密码')); ?>
                

                <h4 style='margin:40px 0 20px;'>常用地址：</h4>
                <div class='addresslist'>
                    <span class='radselect'></span> 北京市海淀区北四环西路58号理想国际大厦 <span class='red'>修改</span> <img src="/img/jian.png"> <img src="/img/jia.png">
                </div>
                <input id='address' class='pinfo' type='text' style='margin-bottom:0;width:650px;'/>
                <div class="padderssslide" >
                    <ul>
                        <li>Lake Gardens,3355</li>
                        <li>Lake Gardens,3355</li>
                        <li>Lake Gardens,3355</li>
                        <li>Lake Gardens,3355</li>
                        <li>Lake Gardens,3355</li>
                        <li>Lake Gardens,3355</li>
                    </ul>
                </div>
                <script type="text/javascript">
                //地址补全
                $('#address').focus(function(){
                    $('.padderssslide').show();
                });
                </script>
                <?php echo CHtml::submitButton('更新信息',array('class'=>'paysubmit2')); ?>
                <?php $this->endWidget(); ?>
            </div>
            <div class="RIGHT fr">
                <a href=""><img src="/img/pic4.jpg"></a>
            </div>
            </div>
        </section>