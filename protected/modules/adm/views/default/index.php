<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>
	<div class="quick-actions_homepage">
      <ul class="quick-actions">
        <li class="bg_lb"> <a href="<?php echo Yii::app()->createUrl("/adm/orders/admin")."?Order[deal]=0";?>"> <i class="icon-tasks"></i> <span class="label label-important"><?php echo $wait_order;?></span> 未处理订单 </a> </li>
        <li class="bg_lg"> <a href="<?php echo Yii::app()->createUrl("/adm/admin/admin");?>"> <i class="icon-user"></i> 用户管理</a> </li>
        <li class="bg_lo"> <a href="<?php echo Yii::app()->createUrl("/adm/restaurant/admin");?>"> <i class="icon-user-md"></i> 餐厅管理</a> </li>

      </ul>
    </div>