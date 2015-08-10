<?php
class ChangepasswordController extends Controller
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
		$time = time();
		if(Yii::app()->request->isAjaxRequest)
		{
			$token = trim(Yii::app()->request->getParam("token"));
			$password = Yii::app()->request->getParam("password");
			$user = User::model()->findByAttributes(array("token"=>$token));
			if(!$user)
			{
				echo json_encode(array("status"=>"error","msg"=>"对不起，找回密码链接已失效！"));
				Yii::app()->end();
			}
			if($time-$user->token_time > 86400)
			{
				echo json_encode(array("status"=>"error","msg"=>"对不起，找回密码链接已失效！"));
				Yii::app()->end();
			}
			$user->password = $password;
			$user->token = "";
			$user->token_time = 0;
			if($user->save())
			{
				echo json_encode(array("success"=>"error","msg"=>"密码修改成功！"));
			}
			else 
			{
				echo json_encode(array("success"=>"error","msg"=>"密码修改失败！"));
			}
			Yii::app()->end();
		}
		if(!Yii::app()->user->isGuest)
		{
			$this->redirect("/");
			Yii::app()->end();
		}
		$token = trim(Yii::app()->request->getParam("sign"));
		if($token == "")
		{
			$this->render("disable");
			Yii::app()->end();
		}
		$user = User::model()->findByAttributes(array("token"=>$token));
		
		if(!$user)
		{
			$this->render("disable");
			Yii::app()->end();
		}
		if($time-$user->token_time > 86400)
		{
			$this->render("disable");
			Yii::app()->end();
		}
		$this->render("index",array('token'=>$token));
	}
}