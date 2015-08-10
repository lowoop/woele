<?php

/**
 * This is the model class for table "tbl_po".
 *
 * The followings are the available columns in table 'tbl_po':
 * @property integer $id
 * @property integer $oid
 * @property integer $rid
 * @property integer $uid
 * @property integer $fid
 * @property integer $num
 * @property double $price
 * @property string $tips
 * @property integer $status
 * @property string $create_datetime
 * @property string $update_datetime
 */
class Po extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_po';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('oid, rid, uid, fid, price, num', 'required'),
			array('oid, rid, uid, fid, num, status', 'numerical', 'integerOnly'=>true),
			array('price, discount', 'numerical'),
			array('tips', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, oid, rid, uid, fid, num, price, tips, status, create_datetime, update_datetime', 'safe', 'on'=>'search'),
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
			'food'=>array(self::BELONGS_TO ,"Food","fid"),
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
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'oid' => 'Oid',
			'rid' => 'Rid',
			'uid' => 'Uid',
			'fid' => 'Fid',
			'num' => 'Num',
			'price' => 'Price',
			'tips' => 'Tips',
			'status' => 'Status',
			'create_datetime' => 'Create Datetime',
			'update_datetime' => 'Update Datetime',
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
		$criteria->compare('uid',$this->uid);
		$criteria->compare('fid',$this->fid);
		$criteria->compare('num',$this->num);
		$criteria->compare('price',$this->price);
		$criteria->compare('tips',$this->tips,true);
		$criteria->compare('status',$this->status);
        $criteria->mergeWith($this->dateRangeSearchCriteria('create_datetime', $this->create_datetime));
        $criteria->mergeWith($this->dateRangeSearchCriteria('update_datetime', $this->update_datetime));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Po the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
