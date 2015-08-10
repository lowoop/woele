<?php
class UserController extends Controller
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
				array('allow',  // allow all users to perform 'index' and 'view' actions
						'actions'=>array('register','registerajax'),
						'users'=>array('*'),
				),
				array (
						'allow',
						//'actions' => array ('*'),
						'roles' => array ('admin','shop','user')
				),
				array (
						'deny', // deny all users
						'users' => array ('*')
				)
		);
	}
	
	public function actionRegister()
	{
		$model = new User();
		if(Yii::app()->request->isAjaxRequest)
		{
			$trans = Yii::app()->db->beginTransaction();
			try
			{
				$model->username = Yii::app()->request->getParam("username");
				$model->role = "user";
				$model->realname = Yii::app()->request->getParam("realname");
				$model->mobile = Yii::app()->request->getParam("mobile");
				$model->email = Yii::app()->request->getParam("email");
				$model->password = Yii::app()->request->getParam("password");
				if($model->save())
				{
					$addressModel = new Address();
					$addressModel->uid = $model->id;
					$addressModel->address = Yii::app()->request->getParam("address");
					$addressModel->street = Yii::app()->request->getParam("street");
					$addressModel->locality = Yii::app()->request->getParam("locality");
					$addressModel->region = Yii::app()->request->getParam("region");
					$addressModel->zipcode = Yii::app()->request->getParam("zipcode");
// 					$addressModel->format_address = Yii::app()->request->getParam("format_address");
					if($addressModel->save())
					{
						$model->address_id = $addressModel->id;
						$model->save();
					}
					else 
					{
						echo json_encode(array('msg'=>'error','errors'=>$addressModel->getErrors()));
						Yii::app()->end();
					}
					$trans->commit();
					echo json_encode(array('msg'=>'success'));
					Yii::app()->end();
				}
				else 
				{
					echo json_encode(array('msg'=>'error','errors'=>$model->getErrors()));
					Yii::app()->end();
				}
			}
			catch (Exception $e)
			{
				$trans->rollback();
				echo json_encode(array('msg'=>'error'));
			}
			Yii::app()->end();
		}
		if(!Yii::app()->user->isGuest)
		{
			$this->redirect("/");
			Yii::app()->end();
		}
		$this->render("register",array('model'=>$model));
	}
	
	public function actionRegisterajax()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$user = new User();
			$user->username = Yii::app()->request->getParam("username");
			$user->role = "user";
			$user->realname = Yii::app()->request->getParam("realname");
			$user->mobile = Yii::app()->request->getParam("mobile");
			$user->email = Yii::app()->request->getParam("email");
			$user->password = Yii::app()->request->getParam("password");
			$address = Yii::app()->request->getParam("address");
			$trans = Yii::app()->db->beginTransaction();
			try
			{
				if($user->save())
				{
					$addr = new Address();
					$addr->address = trim($address);
					$addr->street = Yii::app()->request->getParam("street");
					$addr->locality = Yii::app()->request->getParam("locality");
					$addr->region = Yii::app()->request->getParam("region");
					$addr->zipcode = Yii::app()->request->getParam("zipcode");
					$addr->uid = $user->id;
					if($addr->save())
					{
						$user->address_id = $addr->id;
						$user->save(false);
					}
					$trans->commit();
					$model=new LoginForm;
					$model->username = $user->username;
					$model->password = $user->password;
					$re = $model->login();
					if(!$re)
					{
						echo json_encode(array('msg'=>'error','errors'=>array('errorinfo'=>array('login error'))));
						Yii::app()->end();
					}
					echo json_encode(array('msg'=>'success'));
				}
				else
				{
					echo json_encode(array('msg'=>'error','errors'=>$user->getErrors()));
					Yii::app()->end();
				}
			}
			catch (Exception $e)
			{
				$trans->rollback();
				echo json_encode(array('msg'=>'error','errors'=>array('errorinfo'=>array('add error!'))));
				Yii::app()->end();
			}
		}
		
	}
	public function actionUpdate()
	{
		$model = User::model()->findByPk(Yii::app()->user->id);
		if(Yii::app()->request->isAjaxRequest)
		{
			$trans = Yii::app()->db->beginTransaction();
			try
			{
				$oldpassword = Yii::app()->request->getParam("oldpassword");
				$password = Yii::app()->request->getParam("password");
				$address = Yii::app()->request->getParam("address");
				$model->realname = Yii::app()->request->getParam("realname");
				$model->mobile = Yii::app()->request->getParam("mobile");
				$model->email = Yii::app()->request->getParam("email");
				if($model->save())
				{
					$arr_now = array();
					$arr_old = array();
					$arr_new = array();
					foreach ($model->address as $value)
					{
						$arr_now[] = $value->id;
	 				}
					foreach ($address as $value)
					{
						if($value['id']==0)
						{
							$arr_new[] = $value;
						}
						else 
						{
							$arr_old[$value['id']] = $value;
						}
					}
					$arr_del = array_diff($arr_now, array_keys($arr_old));
					foreach ($arr_del as $value)
					{
						Address::model()->deleteByPk($value);//删除
					}
					foreach ($arr_old as $value)
					{
						if($value['default'] == 1)
						{
							$model->address_id = $value['id'];
							$model->save();
						}
					}
					foreach ($arr_new as $value)
					{
						$addressModel = new Address();
						$addressModel->uid = $model->id;
						$addressModel->address = trim($value['value']);
						$addressModel->street = trim($value['street']);
						$addressModel->locality = trim($value['locality']);
						$addressModel->region = trim($value['region']);
						$addressModel->zipcode = trim($value['zipcode']);
						if($addressModel->save())
						{
							if($value['default'] == 1)
							{
								$model->address_id = $addressModel->id;
								$model->save();
							}
						}
					}
					if($password != md5(""))
					{
						if($oldpassword !== $model->password)
						{
							echo json_encode(array('msg'=>'error','errors'=>array('oldpassword'=>array('原始密码输入错误!'))));
							Yii::app()->end();
						}
						$model->password = $password;
						$model->save();
					}
					$trans->commit();
					echo json_encode(array('msg'=>'success'));
					Yii::app()->end();
				}
				else
				{
					echo json_encode(array('msg'=>'error','errors'=>$model->getErrors()));
					Yii::app()->end();
				}
			}
			catch (Exception $e)
			{
				$trans->rollback();
				echo json_encode(array('msg'=>'error','errors'=>array('errorinfo'=>'add error!')));
			}
			Yii::app()->end();
		}
		$this->render("update",array('model'=>$model));
	}
	
	/* public function actionUserset()
	{
		$model = User::model()->findByAttributes(array('username'=>Yii::app()->user->name));
		if(isset($_POST['User']))
		{
			$trans = Yii::app()->db->beginTransaction();
			try
			{
				$model->attributes=$_POST['User'];
// 				$model->role = "user";
				if($model->save())
				{
					$trans->commit();
// 					$this->redirect("/login");
				}
			}
			catch (Exception $e)
			{
				$trans->rollback();
			}
		}
		$this->render("userset",array('model'=>$model));
	} */
	
}