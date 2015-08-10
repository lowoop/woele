<?php
class PayController extends Controller
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
						//'actions' => array ('*'),
						'roles' => array ('user')
				),
				array (
						'deny', // deny all users
						'users' => array ('*')
				)
		);
	}
	
	public function actionIndex()
	{
		$food = base64_decode(urldecode(Yii::app()->request->getParam("food")));
		$date = base64_decode(urldecode(Yii::app()->request->getParam("date")));
		$time = base64_decode(urldecode(Yii::app()->request->getParam("time")));
		$type = Yii::app()->request->getParam("type");
		$rid = Yii::app()->request->getParam("rid");
		$address = trim(Yii::app()->request->getParam("address"));
		$mobile = trim(Yii::app()->request->getParam("mobile"));
		$cardowner = Yii::app()->request->getParam("cardowner");
		$cardnum = Yii::app()->request->getParam("cardnum");
		$price = (float)Yii::app()->request->getParam("price");
		$foods = explode(",",$food);
		$myprice = $fee = JConfig::getFee();
        $mydiscount = 0;
		$arr_foods = array();
		foreach ($foods as $value)//重新计算总价
		{
			$tmp = explode(":",$value);
			$f = Food::model()->findByPk($tmp[0]);
			if(!$f)
			{
                $this->redirect(Yii::app()->request->urlReferrer);
				Yii::app()->end();
			}
			if($f->rid != $rid)
			{
                $this->redirect(Yii::app()->request->urlReferrer);
				Yii::app()->end();
			}
			$arr_food[$f->id] = $f->attributes;
			$arr_food[$f->id]['num'] = $tmp[1];
			$myprice = bcadd( $myprice,bcmul($f->price ,$tmp[1] ,2),2);
            $mydiscount = bcadd($mydiscount,bcmul($f->discount , $tmp[1],2),2);
		}
        $mydiscount = min(array($mydiscount,$fee));
        $myprice = bcsub($myprice , $mydiscount,2);
		if($myprice != $price)//验证总价是否正确
		{
            $this->redirect(Yii::app()->request->urlReferrer);
			Yii::app()->end();
		}
		$order = new Order();
		$trans = Yii::app()->db->beginTransaction();
		$user = User::model()->findByPk(Yii::app()->user->id);
		try {
			$order->rid = $rid;
			$order->uid = Yii::app()->user->id;
			$order->realname = $user->realname;
			$order->user_address = $address;
			$order->user_mobile = $mobile;
			$order->paytype = $type;
			$order->cardnum = $cardnum;
			$order->cardowner = $cardowner;
			$order->total_price = $price;
			$order->discount = $mydiscount;
			$order->expect_date = $date;
			$order->expect_time = $time;
			$order->fee = $fee;
			if($order->save())
			{
				foreach ($arr_food as $key=>$value)
				{
					$po = new Po();
					$po->oid = $order->id;
					$po->uid = Yii::app()->user->id;
					$po->rid = $rid;
					$po->fid = $value['id'];
					$po->price = $value['price'];
					$po->discount = $value['discount'];
					$po->num = $value['num'];
					$po->save();
				}
				$trans->commit();
                Order::model()->addLog($order,"创建订单");
				$orderid = $order->onum;
				$user = User::model()->findByPk(Yii::app()->user->id);
				if($user && $user->email!="")
				{
					Jmail::sendMail($user->email, "感谢您的预定！", "<h2>您的订单号码为:$orderid</h2> 为避免订单延误，请您再次确认您的手机号码$mobile");
				}
				$restaurant = Restaurant::model()->findByPk($rid);
				if($restaurant && $restaurant->user->email!="")
				{
					Jmail::sendMail($restaurant->user->email, "您的餐厅有新的订单！", "<h2>订单号码为:$orderid</h2> 请您尽快登陆到餐厅页面进行处理.<a target='_blank' href='".WW_DOMAIN."/resorderlist'>>>点此进入<<</a>");
				}
				$admin_mail = JConfig::item("mail.receiver");
				if($admin_mail!="")
				{
					Jmail::sendMail($admin_mail, "有新的订单！", "<h2>订单号码为:$orderid</h2> 请您尽快登陆到后台系统进行处理.<a target='_blank' href='".WW_DOMAIN."/adm/orders/admin?Order[deal]=0'>>>点此进入<<</a>");
				}
				$this->render("thanks",array('mobile'=>$mobile,'orderid'=>$orderid,'address'=>$address));
			}
			else 
			{
				$this->redirect(Yii::app()->request->urlReferrer);
				Yii::app()->end();
			}
			
		}
		catch (Exception $e)
		{
			$trans->rollback();
			$this->redirect(Yii::app()->request->urlReferrer);
			Yii::app()->end();
		}
	}
}