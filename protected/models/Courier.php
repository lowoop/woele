<?php

/**
 * This is the model class for table "tbl_courier".
 *
 * The followings are the available columns in table 'tbl_courier':
 * @property integer $id
 * @property string $name
 * @property string $mobile
 * @property string $moto
 * @property string $email
 * @property integer $status
 * @property string $create_datetime
 */
class Courier extends CActiveRecord
{

    const STATUS_NORMAL=1;
    const STATUS_DELETE=-1;

    const STATUS_WORK_IDLE=0;
    const STATUS_WORK_BUSY=1;

    public static function getStatus($state=null)
    {
        $maps=array(
            self::STATUS_NORMAL=>Yii::t('stat', 'normal'),
            self::STATUS_DELETE=>Yii::t('stat', 'delete'),
        );
        if(is_null($state) || !isset($maps[intval($state)]))
        {
            return $maps;
        }
        return $maps[intval($state)];
    }

    public static function getWorkStatus($state=null)
    {
        $maps=array(
            self::STATUS_WORK_IDLE=>Yii::t('stat', 'idle'),
            self::STATUS_WORK_BUSY=>Yii::t('stat', 'busy'),
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
		return 'tbl_courier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, mobile', 'required'),
			array('mobile, status, isbusy', 'numerical', 'integerOnly'=>true),
			array('name, moto, image', 'length', 'max'=>100),
			array('mobile', 'length', 'max'=>10),
			array('email', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, mobile, moto, email, image, status, isbusy, create_datetime, update_datetime', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => '名字',
			'image' => '头像',
			'mobile' => '手机',
			'moto' => '车型',
			'email' => 'Email',
			'status' => '状态',
			'isbusy' => '配送状态',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('moto',$this->moto,true);
		$criteria->compare('email',$this->email,true);
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
	 * @return Courier the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
