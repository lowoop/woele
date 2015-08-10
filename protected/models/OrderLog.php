<?php

/**
 * This is the model class for table "tbl_order_log".
 *
 * The followings are the available columns in table 'tbl_order_log':
 * @property integer $id
 * @property integer $oid
 * @property integer $rid
 * @property integer $uid
 * @property integer $status
 * @property string $desc
 * @property string $create_datetime
 * @property string $update_datetime
 */
class OrderLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_order_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('oid', 'required'),
			array('oid, rid, uid, status', 'numerical', 'integerOnly'=>true),
			array('desc', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, oid, rid, uid, status, desc, create_datetime, update_datetime', 'safe', 'on'=>'search'),
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
            'restaurant'=>array(self::BELONGS_TO ,"Restaurant","rid"),
            'user'=>array(self::BELONGS_TO ,"User","uid"),
            'order'=>array(self::BELONGS_TO ,"Order","oid"),
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
			'rid' => '餐厅',
			'uid' => '用户',
			'status' => '状态',
			'desc' => '描述',
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
		$criteria->compare('rid',$this->rid);
//		$criteria->compare('uid',$this->uid);
		$criteria->compare('status',$this->status);
		$criteria->compare('desc',$this->desc,true);
        $criteria->mergeWith($this->dateRangeSearchCriteria('create_datetime', $this->create_datetime));
        $criteria->mergeWith($this->dateRangeSearchCriteria('update_datetime', $this->update_datetime));

        if($this->uid) {
            $criteria->join = 'LEFT JOIN tbl_user ON tbl_user.id=t.uid';
            $criteria->compare('tbl_user.username', $this->uid, true);
        }

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
	 * @return OrderLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
