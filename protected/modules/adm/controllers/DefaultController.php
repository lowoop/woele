<?php

class DefaultController extends BController
{
	public function actionIndex()
	{
		$wait_order = Order::model()->countByAttributes(array('deal'=>0));
		$this->render('index',array('wait_order'=>$wait_order));
	}
	public function actionGetMessage()
	{
		$wait_order = Order::model()->countByAttributes(array('status'=>Order::STATUS_WAITING));
		if((int) $wait_order > 0)
		{
			echo json_encode(array('status'=>'yes','msg'=>"您有".$wait_order."条未处理订单,请及时处理!"));
		}
		else {
			echo json_encode(array('status'=>'no'));
		}
	}
}
