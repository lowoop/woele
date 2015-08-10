<?php
class FindpassController extends Controller
{
	public function filters()
	{
				return array(
					'accessControl', // perform access control for CRUD operations
// 					'postOnly + delete', // we only allow deletion via POST request
				);
	}
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
				return array(
					array('allow',  // allow all users to perform 'index' and 'view' actions
						'actions'=>array('index'),
						'users'=>array('*'),
					),
// 					array('allow', // allow authenticated user to perform 'create' and 'update' actions
// 						'actions'=>array('contact'),
// 						'users'=>array('@'),
// 					),
// 					array('allow', // allow admin user to perform 'admin' and 'delete' actions
// 						'actions'=>array('admin','delete'),
// 						'users'=>array('admin'),
// 					),
					array('deny',  // deny all users
						'users'=>array('*'),
					),
				);
	}
	
	public function actionIndex()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$email = Yii::app()->request->getParam("email");
			$user = User::model()->findByAttributes(array('email'=>$email));
			if(!$user)
			{
				echo json_encode(array("status"=>"error","msg"=>"对不起，邮箱不存在！"));
				Yii::app()->end();
			}
			$time = time();
			if($time - $user->token_time <= 86400)
			{
				echo json_encode(array("status"=>"error","msg"=>"对不起，找回密码时间间隔不能低于一小时！"));
				Yii::app()->end();
			}
			$str = $user->email."@".$time."@##uuyytt**";
			$token = md5($str);
			$link = WW_DOMAIN."/changepassword"."?sign=$token";
			$user->token = $token;
			$user->token_time = $time;
			if($user->save(false))
			{
				Jmail::sendMail($email,"找回密码链接","请点击链接找回密码：<a href='$link'>点击这里</a>");
				echo json_encode(array("status"=>"success","msg"=>"发送成功！"));
			}
			Yii::app()->end();
		}
		$this->render("index");
	}
	
}
?>