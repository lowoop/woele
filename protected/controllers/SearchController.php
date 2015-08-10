<?php

class SearchController extends Controller
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionIndex()
	{
        $purifier = new CHtmlPurifier();
		$params = array();
		$now = time();
		$date = date("Y-m-d");
		$code = $params['code'] = is_string(Yii::app()->request->getParam("code"))?Yii::app()->request->getParam("code"):"";
		$keyword = $params['keyword'] = is_string(Yii::app()->request->getParam("keyword"))?CHtml::encode($purifier->purify(Yii::app()->request->getParam("keyword"))):"";
		$c = new CDbCriteria();
// 		$c->join = "JOIN idc_user on t.id=idc_user.user_id";
// 		$c->condition = "idc_user.idc_id=$idc_id";	
		$c->addCondition("t.`status` = 1");
		$c->addCondition("t.`area` like :code");
		$c->params[':code'] = "%,$code,%";
		if(trim($keyword!=""))
		{
			$c->addCondition("t.`name` like :keyword");
			$c->params[':keyword'] = "%$keyword%";
// 			$c->join = "JOIN tbl_food on t.id=tbl_food.rid";
// 			$c->addCondition("tbl_food.name like :keyword");
// 			$c->params[':keyword'] = "%$keyword%";
		}
		$c->order = "vip desc, sortnum desc";
// 		$restaurant = Restaurant::model()->findAll("status=1 and area like :code ",array('code'=>"%,$code,%"));
		$restaurant = Restaurant::model()->findAll($c);
// 		print_r(Yii::getLogger()->getLogs('trace',array('system.db.CDbCommand')));
		$arr_rest = array();
		$arr_tag = array();
		$str_tag = "";
		if($restaurant)
		{
			foreach ($restaurant as $value)
			{
				$open = strtotime($date." ".$value->open_time);
				$close = strtotime($date." ".$value->close_time);
				if($now <= $close && $now >= $open)
				{
					$arr_rest['open'][] = $value->attributes;
				}
				else 
				{
					$arr_rest['close'][] = $value->attributes;
				}
				$str_tag .= ",".trim($value->tags,",");
			}
		}
		$tags = array_flip(array_flip(explode(",", trim($str_tag,","))));
		foreach ($tags as $value)
		{
			if(trim($value,":")=="" || trim($value)=="") continue;
			$tmp = explode(":", $value);
			if(trim($tmp[0])==""||trim($tmp[1])=="") continue;
			$tagname = Tag::model()->findByPk($tmp[0])->name;
			$tagvaluename = TagValue::model()->findByPk($tmp[1])->value;
			$arr_tag[$tmp[0]]['name'] = $tagname;
			$arr_tag[$tmp[0]]['value'][$tmp[1]] = $tagvaluename;
		}
		ksort($arr_tag);
// 		print_r($arr_tag);
		$this->render('index',array(
			'params'=>$params,
			'restaurant'=>$arr_rest,
			'tags'=>$arr_tag,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
