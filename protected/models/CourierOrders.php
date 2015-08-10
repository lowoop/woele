<?php

/**
 * This is the model class for table "tbl_courier_orders".
 *
 * The followings are the available columns in table 'tbl_courier_orders':
 * @property integer $id
 * @property integer $oid
 * @property integer $cid
 * @property integer $status
 * @property string $create_datetime
 * @property string $update_datetime
 */
class CourierOrders extends CActiveRecord
{
    const STATUS_TRANS=0;
    const STATUS_COMPLETE=1;
    const STATUS_UNTRANS=-1;

    public static function getStatus($state=null)
    {
        $maps=array(
            self::STATUS_TRANS=>'配送中',
            self::STATUS_COMPLETE=>'配送完成',
            self::STATUS_UNTRANS=>'取消配送',
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
		return 'tbl_courier_orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('oid, cid', 'required'),
			array('oid, cid, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, oid, cid, status, create_datetime, update_datetime', 'safe', 'on'=>'search'),
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
            'order'=>array(self::BELONGS_TO,"Order","oid"),
            'courier'=>array(self::BELONGS_TO,"Courier","cid"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'oid' => '订单ID',
			'cid' => '配送人',
			'status' => '状态',
			'create_datetime' => '创建时间',
			'update_datetime' => '更新时间',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('oid',$this->oid);
		$criteria->compare('cid',$this->cid);
		$criteria->compare('status',$this->status);
        $criteria->mergeWith($this->dateRangeSearchCriteria('create_datetime', $this->create_datetime));
        $criteria->mergeWith($this->dateRangeSearchCriteria('update_datetime', $this->update_datetime));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'create_datetime DESC',
            ),
		));
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
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CourierOrders the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
