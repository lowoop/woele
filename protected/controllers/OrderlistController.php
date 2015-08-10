<?php
class OrderlistController extends Controller
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
		$criteria = new CDbCriteria();
		$criteria->order = 'create_datetime desc'; //按什么字段来排序
//		$criteria->addCondition('status=1');
		$criteria->addCondition('`uid`='.Yii::app()->user->id);
		$count = Order::model()->count($criteria);//count() 函数计算数组中的单元数目或对象中的属性个数。
		$pager = new CPagination($count);
		$pager -> pageSize = 10; //每页显示的行数
		$pager->applyLimit($criteria);
		$orderList = Order::model()->findAll($criteria);//查询所有的数据
//		echo $count;
		$this->render('index',array('pages'=>$pager,'data'=>$orderList));
	}
	
}