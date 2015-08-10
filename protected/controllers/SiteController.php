<?php

class SiteController extends Controller
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
						'actions'=>array('index','login','logout','auth','error','captcha'),
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
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'minLength'=>4,  //最短为4位
                'maxLength'=>4,   //是长为4位
                'backColor'=>0xFFFFFF,
//				'fixedVerifyCode' => substr(md5(microtime()),11,4),
				'testLimit'=>999,
            ),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$ad = JConfig::item("common.ad");
        $notice = JConfig::item("common.notice");
		if(empty($ad))
			$ad = array();
		$this->render('index',array('ad'=>$ad,'notice'=>$notice));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		/* if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		} */

		// collect user input data
		if(isset($_POST['username']))
		{
            $code = new Code();
            $code->verifyCode = is_string(Yii::app()->request->getParam('yzm'))?Yii::app()->request->getParam('yzm'):"";
            if(!$code->validate())
            {
                echo CJSON::encode(array('status'=>'errcode'));
                Yii::app()->end();
            }
			$model->attributes=$_POST;
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			{
				echo CJSON::encode(array('status'=>'success'));
			}
			else
			{
				echo CJSON::encode($model->getErrors());
			}
			Yii::app()->end();
		}

		// display the login form
		if(Yii::app()->user->isGuest)
		{
			$this->render('login',array('model'=>$model));
		}
		else
		{
			$this->redirect("/");
		}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->request->urlReferrer);
	}
	public function actionAuth($provider)
	{
		// 导入OAuth2China
        if(!is_string($provider))
        {
            $provider = "weibo";
        }
		Yii::import('ext.OAuth2China.OAuth2China');
	
		// 配置给平台参数
		$providers = array(
				'weibo' => array(
						'id' => '2669862421',
						'secret' => '885e75f7fbf2d46269fd8cc4e2bb7385',
				),
// 				'qq' => array(
// 						'id' => 'APP ID',
// 						'secret' => 'APP KEY',
// 				),
// 				'douban' => array(
// 						'id' => 'API Key',
// 						'secret' => 'Secret',
// 				),
// 				'renren' => array(
// 						'id' => 'API key',
// 						'secret' => 'Secret key',
// 				),
		);
	
		$OAuth2China = new OAuth2China($providers);
	
		$provider = $OAuth2China->getProvider($provider);
	
		if(!isset($_GET['code']))
		{
			// 跳转到授权页面
			$provider->redirect();
		}
		else
		{
			$token = $provider->getAccessToken($_GET['code']);
			$user = User::model()->findByAttributes(array('uuid'=>$token['provider_uid'],'source'=>'weibo'));
			if(!$user)
			{
				$userinfo = $provider->getUserInfo($token['access_token'],$token['provider_uid']);
				if(User::model()->findByAttributes(array('username'=>$userinfo->name)))
				{
					$name = $userinfo->name.$userinfo->id;
				}
				else 
				{
					$name = $userinfo->name;
				}
				$user = new User();
				$user->username = $name;
				$user->password = "nopassword";
				$user->uuid = $userinfo->id;
				$user->source = "weibo";
				$user->role = "user";
				if(!$user->save(false))
				{
					print_r($user->getErrors());
				}
			}
			$model=new LoginForm;
			$model->username = $user->username;
			$model->password = $user->password;
			$model->source = "weibo";
			$re = $model->login();
			if(!$re)
			{
				exit("login error!!!");
			}
// 			print_r($userinfo);
// 			print_r(Yii::app()->user);
			$this->redirect(Yii::app()->user->returnUrl);
		}
	}
}