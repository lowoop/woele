<?php
class ResorderlistController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array ('accessControl');  // perform access control for CRUD operations

	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array (
// 				array('allow',  // allow all users to perform 'index' and 'view' actions
// 						'actions'=>array('register'),
// 						'users'=>array('*'),
// 				),
				array (
						'allow',
//						'actions' => array ('*'),
						'roles' => array ('shop')
				),
				array (
						'deny', // deny all users
						'users' => array ('*')
				)
		);
	}
	
	public function actionIndex()
	{
		$status = Yii::app()->request->getParam("status","3");
		$criteria = new CDbCriteria();
		$criteria->order = 'create_datetime desc'; 
		$restaurant = Restaurant::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
		if(!$restaurant)
		{
			$this->redirect("/error");
			Yii::app()->end();
		}
//		$criteria->addCondition('status=1');
        if($status == 2)
        {
            $criteria->addInCondition("status",array(Order::STATUS_COMPLETE,Order::STATUS_TRANS,Order::STATUS_CLOSED,Order::STATUS_REFUND,Order::STATUS_DELETE));
        }
        else
        {
            $criteria->addCondition("`status`='".$status."'");
        }
		$criteria->addCondition('`rid`='.$restaurant->id);
		$criteria->addCondition("(paytype='cash' or payment=1)");//已支付或现金支付订单
		$count = Order::model()->count($criteria);
		$pager = new CPagination($count);
		$pager -> pageSize = 10; 
		$pager->applyLimit($criteria);
		$orderList = Order::model()->findAll($criteria);
		Order::model()->updateAll(array('tag'=>1));
//		echo $count;
		$this->render('index',array('pages'=>$pager,'data'=>$orderList,'status'=>$status));
	}
	
	public function actionRefresh()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$status = Yii::app()->request->getParam("status","3");
			$criteria = new CDbCriteria();
			$criteria->order = 'create_datetime desc';
			$restaurant = Restaurant::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
			if(!$restaurant)
			{
				$this->redirect("/error");
				Yii::app()->end();
			}
			//		$criteria->addCondition('status=1');
			$criteria->addCondition("`tag`= 0");
			$criteria->addCondition("`status`='".$status."'");
			$criteria->addCondition('`rid`='.$restaurant->id);
			$criteria->addCondition("(paytype='cash' or payment=1)");//已支付或现金支付订单
			$count = Order::model()->count($criteria);
			$orderList = Order::model()->findAll($criteria);
			Order::model()->updateAll(array('tag'=>1));
			$arr_data = array();
			foreach ($orderList as $value)
			{
				$tmp = array();
				$tmp['id'] = $value->id;
				$tmp['oid'] = $value->onum;
				$tmp['create_date'] = date("Y-m-d",$value->create_datetime);
				$tmp['create_time'] = date("H:i:s",$value->create_datetime);
				$tmp['total'] = $value->total_price;
				$tmp['microtime'] = $value->create_datetime*1000;
				$tmp['status'] = $value->status;
				$tmp['fee'] = $value->fee;
				foreach ($value->po as $v)
				{
					$tmp['foods'][] = array(
						'name'=>$v->food->name,
						'num'=>$v->num,
						'price'=>$v->food->price,
						);
				}
				$arr_data[] = $tmp;
			}
			echo json_encode(array('msg'=>'success','total'=>$count,'data'=>$arr_data));
			Yii::app()->end();
		//		echo $count;
		}
	}
	
	public function actionApply()
	{
		$oid = Yii::app()->request->getParam("oid");
		$type = Yii::app()->request->getParam("type");
		$time = Yii::app()->request->getParam("time");
		$order = Order::model()->findByPk($oid);
		if(!$order)
		{
			echo json_encode(array("msg"=>"failed"));
			Yii::app()->end();
		}
		$restaurant = Restaurant::model()->findByAttributes(array('uid'=>Yii::app()->user->id));
		if($order->rid != $restaurant->id)
		{
			echo json_encode(array("msg"=>"failed"));
			Yii::app()->end();
		}
		if($type=="apply")
		{
			$order->food_datetime = time()+$time*60;
			$order->status = 2;
		}
		else 
		{
			$order->status = -2;
		}
		if($order->save(false))
        {
            Order::model()->addLog($order,Order::getStatus($order->status)."订单");
			$admin_mail = JConfig::item("mail.receiver");
			if($admin_mail!="")
			{
				Jmail::sendMail($admin_mail, $restaurant->name.Order::getStatus($order->status)."了一个订单！", "<h2>订单号为:$oid</h2> 请您尽快登陆到后台系统进行处理.<a target='_blank' href='".WW_DOMAIN."/adm/orders/admin?Order[deal]=0'>>>点此进入<<</a>");
			}
			echo json_encode(array("msg"=>"success"));
			Yii::app()->end();
		}
		else 
		{
			echo json_encode(array("msg"=>"failed"));
			Yii::app()->end();
		}
	}
	
}