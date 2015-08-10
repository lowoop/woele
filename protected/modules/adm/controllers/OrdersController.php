<?php

class OrdersController extends BController
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
		$model=new Order;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Order']))
		{
			$model->attributes=$_POST['Order'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['Order']))
		{
			$model->attributes=$_POST['Order'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$model = $this->loadModel($id);
		$model->status = Order::STATUS_DELETE;
		$model->save();
        $cOrder = CourierOrders::model()->findByAttributes(array('oid'=>$model->id));
        $cOrder->status = CourierOrders::STATUS_UNTRANS;
        $cOrder->save();
        Courier::model()->updateByPk($model->courier, array('isbusy' => 0));
        Order::model()->addLog($model,Order::getStatus($model->status)."订单");
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
		$dataProvider=new CActiveDataProvider('Order');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Order('search');
		$model->unsetAttributes();  // clear any default values
        $criteria=new CDbCriteria;
        if(isset($_GET['t']))
        {
            if($_GET['t'] == 0)
            {
                $criteria->addInCondition("status",array(Order::STATUS_WAITING));
            }
            elseif($_GET['t']==1)
            {
                $criteria->addInCondition("status",array(Order::STATUS_ACCEPT,Order::STATUS_REFUND,Order::STATUS_TRANS));
            }
            elseif($_GET['t']==2)
            {
                $criteria->addInCondition("status",array(Order::STATUS_COMPLETE,Order::STATUS_CLOSED,Order::STATUS_DELETE));
            }
        }
		if(isset($_GET['Order']))
			$model->attributes=$_GET['Order'];

		$this->render('admin',array(
			'model'=>$model,
			'criteria'=>$criteria,
		));
	}

	public function actionConf()
	{
		$id = Yii::app()->request->getParam("id");
		$status = Yii::app()->request->getParam("status");
		$courier = Yii::app()->request->getParam("courier");
		$courier_mobile = Yii::app()->request->getParam("courier_mobile");
		$desc = Yii::app()->request->getParam("desc");
		$send_datetime = Yii::app()->request->getParam("send_datetime");
		$model = Order::model()->findByPk($id);
		if(!$model)
		{
			echo json_encode(array('status'=>'failed','error'=>'order is null'));
			Yii::app()->end();
		}
        if($model->status == $status)
        {
            echo json_encode(array('status'=>'error','msg'=>'不能与原状态相同!'));
            Yii::app()->end();
        }
		$model->status = $status;
		if($status == Order::STATUS_TRANS)
		{
			$model->courier = $courier;
			$model->courier_mobile = $courier_mobile;
			$model->send_datetime = strtotime($send_datetime);
		}
		$model->desc = $desc;
		$model->deal = 1;
		if($model->save())
		{
            if($model->cour)
            {
                if ($status == Order::STATUS_TRANS)
                {
                    Courier::model()->updateByPk($model->courier, array('isbusy' => 1));
                    $courier_order = new CourierOrders();
                    $courier_order->cid = $model->courier;
                    $courier_order->oid = $model->id;
                    $courier_order->save();
                }
                else
                {
                    if($status == Order::STATUS_COMPLETE)
                    {
                        $cOrder = CourierOrders::model()->findByAttributes(array('oid'=>$model->id));
                        $cOrder->status = CourierOrders::STATUS_COMPLETE;
                        $cOrder->save();
                    }
                    else
                    {
                        $cOrder = CourierOrders::model()->findByAttributes(array('oid'=>$model->id));
                        $cOrder->status = CourierOrders::STATUS_UNTRANS;
                        $cOrder->save();
                    }
                    Courier::model()->updateByPk($model->courier, array('isbusy' => 0));
                }
            }
            Order::model()->addLog($model,Order::getStatus($model->status)."订单");
			echo json_encode(array('status'=>'success'));
			Yii::app()->end();
		}
		echo json_encode(array('status'=>'error'));
		Yii::app()->end();
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Order the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Order::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Order $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='order-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
