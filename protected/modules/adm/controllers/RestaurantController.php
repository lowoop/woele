<?php

class RestaurantController extends BController
{
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Restaurant;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Restaurant']))
		{
			$model->attributes=$_POST['Restaurant'];
			if($model->save())
			{
				if(isset($_POST['series']))
				{
					foreach ($_POST['series'] as $value)
					{
						$m = new RestaurantSeries();
						$m->rid = $model->id;
						$m->sid = $value;
						$m->save();
					}
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Restaurant']))
		{
			$model->attributes=$_POST['Restaurant'];
			if($model->save())
			{
				RestaurantSeries::model()->deleteAllByAttributes(array('rid'=>$id));
				if(isset($_POST['series']))
				{
					foreach ($_POST['series'] as $value)
					{
						$m = new RestaurantSeries();
						$m->rid = $model->id;
						$m->sid = $value;
						$m->save();
					}
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}
        $model->labels = explode(",",trim($model->labels,","));
		$model->area = trim($model->area,",");
		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		$model->status = Restaurant::STATUS_DELETE;
		$model->save();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->redirect("admin");
		Yii::app()->end();
		$dataProvider=new CActiveDataProvider('Restaurant');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Restaurant('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Restaurant']))
			$model->attributes=$_GET['Restaurant'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Restaurant the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Restaurant::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Restaurant $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='restaurant-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
