<?php

class OrderController extends Controller
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
			array (
					'allow',
					'actions' => array ('*'),
			),
		);
	}
	public function actionIndex()
	{		
		$query = trim(Yii::app()->request->getParam("query"),",");
		$date =Yii::app()->request->getParam("date");
		$time =Yii::app()->request->getParam("time");
		$arr_query = explode(",",$query);
		$arr_food = array();
        $fee = JConfig::getFee();
		$order_price = $fee;
		if(empty($arr_query))
		{
			$this->redirect("/error");
		}
		$tmp = explode(":",$arr_query[0]);
		$food1 = Food::model()->findByPk($tmp[0]);
		if(!$food1)
		{
			$this->redirect("/error");
		}
		$restaurant = $food1->restaurant;//根据第一个菜单取得餐厅
		$order = array();
        $discount = 0;
		foreach ($arr_query as $value)
		{
			if(trim($value) == "") continue;
			$tmp = explode(":",$value);
			if(count($tmp)!=2) continue;
			$food = Food::model()->findByPk($tmp[0]);
			if(!$food) continue;
			if($food->rid != $restaurant->id) continue;//不是此餐厅的食物拒绝
			$arr_food[$food->id] = $food->attributes;
			$arr_food[$food->id]['num'] = $tmp[1];
			$order_price += $tmp[1] * $food->price;
            $discount += $tmp[1] * $food->discount;
			$order['food'][] = $food->id.":".$tmp[1];
		}
        $discount = min(array($discount,$fee));
        $order_price = $order_price - $discount;
		$order['date'] = $date;
		$order['time'] = $time;
		
		$user = "";
		if(!Yii::app()->user->isGuest)
		{
			$user = User::model()->findByPk(Yii::app()->user->id);
			$this->render("index",array(
				'restaurant'=>$restaurant,
				'foods'=>$arr_food,
				'price'=>$order_price,
				'discount'=>$discount,
				'order'=>$order,
				'user'=>$user,
		    ));
		}
		else
		{
			$this->render("indexno",array(
				'restaurant'=>$restaurant,
				'foods'=>$arr_food,
				'price'=>$order_price,
				'discount'=>$discount,
				'order'=>$order,
			));
		}
	}
}