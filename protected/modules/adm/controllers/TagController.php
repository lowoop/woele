<?php

class TagController extends BController
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
		$model=new Tag;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tag']))
		{
			$model->attributes=$_POST['Tag'];
			if($model->save())
			{
				$arr_value = $_POST['values'];
				foreach ($arr_value as $value)
				{
					$tmp = explode(":", $value);
					if(trim($tmp[1])=="") continue;
					$tv = new TagValue();
					$tv->tid = $model->id;
					$tv->value = $tmp[1];
					$tv->save();
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

		if(isset($_POST['Tag']))
		{
			$model->attributes=$_POST['Tag'];
			if($model->save())
			{
				$arr_edit = array();
				$arr_del = array();
				$arr_add = array();
				$arr_value = $_POST['values'];
				foreach ($arr_value as $value)
				{
					$tmp = explode(":", $value);
					if($tmp[0] == 0)
					{
						if(trim($tmp[1])!="")
						{
							$arr_add[] = $tmp[1];
						}
					}
					else
					{
						if(trim($tmp[1])=="")
						{
							$arr_del[$tmp[0]] = $tmp[1];
						}
						else 
						{
							$arr_edit[$tmp[0]] = $tmp[1];
						}
					}
				}
				foreach ($arr_edit as $key=>$value)
				{
					$tv = TagValue::model()->findByPk($key);
					$tv->value = $value;
					$tv->save();
				}
				foreach ($arr_del as $key=>$value)
				{
					TagValue::model()->deleteByPk($key);
				}
				foreach ($arr_add as $key=>$value)
				{
					$tv = new TagValue();
					$tv->value = $value;
					$tv->tid = $model->id;
					$tv->save();
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}

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
		$this->loadModel($id)->delete();

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
		$dataProvider=new CActiveDataProvider('Tag');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Tag('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Tag']))
			$model->attributes=$_GET['Tag'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionGetTagValue()
	{
		$id = Yii::app()->request->getParam("id");
		$values = TagValue::model()->findAllByAttributes(array('tid'=>$id));
		$array = array();
		if($values)
		{
			foreach ($values as $value)
			{
				$array[] = array('id'=>$value->id,'name'=>$value->value);
			}
		}
		echo json_encode(array('data'=>$array,'status'=>'success'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Tag the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Tag::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Tag $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tag-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
