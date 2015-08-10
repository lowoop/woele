<?php
class UsersetController extends Controller
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
						'roles' => array ('admin','shop','user')
				),
				array (
						'deny', // deny all users
						'users' => array ('*')
				)
		);
	}
	
	public function actionMobile()
	{
		if(Yii::app()->user->isGuest || !Yii::app()->request->isPostRequest)
		{
			echo "error!";
			Yii::app()->end();
		}
		$user = User::model()->findByPk(Yii::app()->user->id);
		if(!$user)
		{
			echo "error,not defind!";
			Yii::app()->end();
		}
		$mobile = Yii::app()->request->getParam("mobile");
		$user->mobile = $mobile;
		if($user->save(false))
		{
			echo json_encode(array('msg'=>'success'));
		}
		else 
		{
			print_r($user->getErrors());
			echo json_encode(array('msg'=>'failed'));
		}
	}
	
	public function actionAddress()
	{
		if(Yii::app()->user->isGuest || !Yii::app()->request->isPostRequest)
		{
			echo "error!";
			Yii::app()->end();
		}
		$user = User::model()->findByPk(Yii::app()->user->id);
		if(!$user)
		{
			echo "error,not defind!";
			Yii::app()->end();
		}
		$address = Yii::app()->request->getParam("address");
		if(empty($address))
		{
			echo "error!";
			Yii::app()->end();
		}
		$arr_now = array();
		$arr_old = array();
		$arr_new = array();
		foreach ($user->address as $value)
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
		$trans = Yii::app()->db->beginTransaction();
		try
		{
			$arr_del = array_diff($arr_now, array_keys($arr_old));
			foreach ($arr_del as $value)
			{
				Address::model()->deleteByPk($value);//删除
			}
			foreach ($arr_old as $value)
			{
				if($value['default'] == 1)
				{
					$user->address_id = $value['id'];
					$user->save(false);
				}
			}
			foreach ($arr_new as $value)
			{
				$addressModel = new Address();
				$addressModel->uid = $user->id;
				$addressModel->address = trim($value['value']);
				$addressModel->street = trim($value['street']);
				$addressModel->locality = trim($value['locality']);
				$addressModel->region = trim($value['region']);
				$addressModel->zipcode = trim($value['zipcode']);
				if($addressModel->save())
				{
					if($value['default'] == 1)
					{
						$user->address_id = $addressModel->id;
						$user->save(false);
					}
				}
			}
			$trans->commit();
			echo json_encode(array('msg'=>'success'));
		}
		catch (Exception $e)
		{
			$trans->rollback();
			echo json_encode(array('msg'=>'error','errors'=>array('errorinfo'=>'update error!')));
		}
		Yii::app()->end();
	}
	
}