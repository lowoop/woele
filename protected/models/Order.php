<?php

/**
 * This is the model class for table "tbl_order".
 *
 * The followings are the available columns in table 'tbl_order':
 * @property integer $id
 * @property integer $rid
 * @property integer $uid
 * @property string $realname
 * @property string $user_address
 * @property string $user_mobile
 * @property string $expect_date
 * @property string $expect_time
 * @property double $total_price
 * @property string $paytype
 * @property string $payment
 * @property string $cardnum
 * @property string $cardowner
 * @property string $courier
 * @property string $courier_mobile
 * @property integer $status
 * @property integer $deal
 * @property string $food_datetime
 * @property string $send_datetime
 * @property string $finish_datetime
 * @property string $create_datetime
 * @property string $update_datetime
 */
class Order extends CActiveRecord
{
	const STATUS_CLOSED = 0;
	const STATUS_COMPLETE = 1;
	const STATUS_TRANS = 4;
	const STATUS_WAITING = 3;
	const STATUS_ACCEPT = 2;
	const STATUS_REFUSE = -2;
	const STATUS_DELETE=-1;
	
	const DEAL_YES = 0;
	const DEAL_NO  = 1;
	
	const PAYMENT_NOPAY=0;
	const PAYMENT_PAY=1;
	const STATUS_REFUND=2;
	
	public static function getStatus($state=null)
	{
		$maps=array(
				self::STATUS_CLOSED=>Yii::t('order', 'closed'),
				self::STATUS_COMPLETE=>Yii::t('order', 'complete'),
				self::STATUS_TRANS=>Yii::t('order', 'trans'),
				self::STATUS_WAITING=>Yii::t('order', 'waiting'),
				self::STATUS_ACCEPT=>Yii::t('order', 'accept'),
				self::STATUS_REFUSE=>Yii::t('order', 'refuse'),
				self::STATUS_DELETE=>Yii::t('order', 'delete'),
		);
		if(is_null($state) || !isset($maps[intval($state)]))
		{
			return $maps;
		}
		return $maps[intval($state)];
	}
	
	public static function getCofStatus($now="")
	{
		if($now=="")
		{
			$maps=array(
					self::STATUS_CLOSED=>Yii::t('order', 'closed'),
					self::STATUS_COMPLETE=>Yii::t('order', 'complete'),
					self::STATUS_TRANS=>Yii::t('order', 'trans'),
					self::STATUS_WAITING=>Yii::t('order', 'waiting'),
					self::STATUS_ACCEPT=>Yii::t('order', 'accept'),
					self::STATUS_REFUSE=>Yii::t('order', 'refuse'),
					self::STATUS_DELETE=>Yii::t('order', 'delete'),
			);
		}
		elseif ($now==3)
		{
			$maps=array(
					self::STATUS_CLOSED=>Yii::t('order', 'closed'),
					self::STATUS_REFUSE=>Yii::t('order', 'refuse'),
					self::STATUS_DELETE=>Yii::t('order', 'delete'),
			);
		}
		elseif ($now==2)
		{
			$maps=array(
					self::STATUS_CLOSED=>Yii::t('order', 'closed'),
					self::STATUS_COMPLETE=>Yii::t('order', 'complete'),
					self::STATUS_TRANS=>Yii::t('order', 'trans'),
					self::STATUS_DELETE=>Yii::t('order', 'delete'),
			);
		}
		return $maps;
	}
	
	public static function getPayment($state=null)
	{
		$maps=array(
				self::PAYMENT_NOPAY=>Yii::t('order', 'nopay'),
				self::PAYMENT_PAY=>Yii::t('order', 'payment'),
				self::STATUS_REFUND=>Yii::t('order', 'refund'),
		);
		if(is_null($state) || !isset($maps[intval($state)]))
		{
			return $maps;
		}
		return $maps[intval($state)];
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rid, uid, realname, user_address, user_mobile, total_price, paytype', 'required'),
			array('rid, onum, uid, status, deal, cardnum, courier', 'numerical', 'integerOnly'=>true),
			array('total_price', 'numerical'),
			array('realname, user_address', 'length', 'max'=>255),
			array('onum, user_mobile, expect_date, paytype, payment, courier_mobile', 'length', 'max'=>20),
			array('expect_time, cardowner', 'length', 'max'=>50),
            array('cardnum', 'length', 'is'=>16),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, onum, rid, uid, realname, user_address, user_mobile, expect_date, expect_time, total_price, paytype, payment, cardnum, cardowner, courier, courier_mobile, status, deal, food_datetime, send_datetime, finish_datetime, create_datetime, update_datetime,desc', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'po'=>array(self::HAS_MANY ,"Po","oid"),
			'restaurant'=>array(self::BELONGS_TO ,"Restaurant","rid"),
			'user'=>array(self::BELONGS_TO ,"User","uid"),
			'cour'=>array(self::BELONGS_TO ,"Courier","courier"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'onum' => '订单号',
			'rid' => '餐厅',
			'uid' => '用户',
			'realname' => '姓名',
			'user_address' => '用户地址',
			'user_mobile' => '用户手机',
			'expect_date' => 'Expect Date',
			'expect_time' => 'Expect Time',
			'total_price' => '总价',
			'paytype' => '支付方式',
			'payment' => '支付',
			'cardnum' => 'Cardnum',
			'cardowner' => 'Cardowner',
			'courier' => '配送人',
			'courier_mobile' => '配送人电话',
			'status' => '状态',
			'deal' => 'Deal',
			'desc' => '备注',
			'food_datetime' => '预计出餐时间',
			'send_datetime' => '预计送达时间',
			'finish_datetime' => '完成时间',
			'create_datetime' => '创建时间',
			'update_datetime' => '更新时间',
		);
	}
	public function behaviors()
	{
		return array(
				'timestamp'=>array(
						'class'=>'zii.behaviors.CTimestampBehavior',
						'createAttribute'=>'create_datetime',
						'updateAttribute'=>'update_datetime',
						'setUpdateOnCreate'=>true,
				),
				'dateRangeSearch'=>array(
						'class'=>'ext.behaviors.DateRangeSearchBehavior',
				),
		);
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search($c=null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('rid',$this->rid);
		//$criteria->compare('uid',$this->uid);
		$criteria->compare('onum',$this->onum,true);
		$criteria->compare('realname',$this->realname,true);
		$criteria->compare('user_address',$this->user_address,true);
		$criteria->compare('user_mobile',$this->user_mobile,true);
		$criteria->compare('expect_date',$this->expect_date,true);
		$criteria->compare('expect_time',$this->expect_time,true);
		//$criteria->compare('total_price',$this->total_price);
		$criteria->compare('paytype',$this->paytype,true);
		$criteria->compare('payment',$this->payment,true);
		$criteria->compare('cardnum',$this->cardnum,true);
		$criteria->compare('cardowner',$this->cardowner,true);
		$criteria->compare('courier',$this->courier,true);
		$criteria->compare('courier_mobile',$this->courier_mobile,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('deal',$this->deal);
        $criteria->mergeWith($this->dateRangeSearchCriteria('food_datetime', $this->create_datetime));
        $criteria->mergeWith($this->dateRangeSearchCriteria('send_datetime', $this->create_datetime));
        $criteria->mergeWith($this->dateRangeSearchCriteria('finish_datetime', $this->create_datetime));
        $criteria->mergeWith($this->dateRangeSearchCriteria('create_datetime', $this->create_datetime));
        $criteria->mergeWith($this->dateRangeSearchCriteria('update_datetime', $this->update_datetime));
        if($this->total_price)
        {
            $criteria->addBetweenCondition('total_price',$this->total_price[0],$this->total_price[1]);
        }
        if($this->uid) {
            $criteria->join = 'LEFT JOIN tbl_user ON tbl_user.id=t.uid';
            $criteria->compare('tbl_user.username', $this->uid, true);
        }
        if($c && $c instanceof CDbCriteria)
        {
            $criteria->mergeWith($c);
        }
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
					'defaultOrder'=>'create_datetime DESC',
				),
		));
	}

    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $start = date("ymd0000");
                $end = date("ymd9999");
                $now = Order::model()->count("`onum`>$start and `onum`<=$end");
                $this->onum = $start + $now + 1;
                return true;
            }
            return true;
        }
        return false;
    }
	
	public function getFoodList()
	{
		$str = "";
		if($this->po)
		{
			foreach ($this->po as $value)
			{
				if($value->food)
				{
					$str .= "<i class='icon-ok-sign'></i> ".$value->food->name;
				}
				else
				{
					$str .= $value->fid;
				}
				$str .= " $".floatval($value->price);
				$str .= "*".$value->num."份";
				$str .= "<br>";
			}
		}
		$str .= "外卖费:$".$this->fee;
        if($this->discount!=0)
        {
            $str .="-".$this->discount;
        }
		return $str;
	}


    public function addLog($order,$desc="")
    {
        if(!is_object($order))
        {
            return false;
        }
        $order_log = new OrderLog();
        $order_log->oid = $order->id;
        $order_log->uid = $order->uid;
        $order_log->rid = $order->rid;
        $order_log->status = $order->status;
        $order_log->desc = $desc;
        return $order_log->save();
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Order the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
