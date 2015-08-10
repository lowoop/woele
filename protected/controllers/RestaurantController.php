<?php

class RestaurantController extends Controller
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
		$id = Yii::app()->request->getParam("id");
		$restaurant = Restaurant::model()->findByPk($id);
		if(!$restaurant)
		{
			$this->redirect("/error");
		}
		$food = Food::model()->findAllByAttributes(array('rid'=>$restaurant->id,'status'=>1));
		$types = array();
		$arr_food = array();
		if($food)
		{
			foreach ($food as $value)
			{
				if(array_key_exists($value->type, $types))
				{
					$types[$value->type] ++;
				}
				else 
				{
					$types[$value->type] = 1;
				}
				$arr_food[] = $value->attributes;
			}
		}
// 		print_r($types);
		$this->render("index",array(
			'restaurant'=>$restaurant,
			'foods'=>$arr_food,
			'types'=>$types,
		));
	}
}