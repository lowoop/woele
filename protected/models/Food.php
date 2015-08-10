<?php

/**
 * This is the model class for table "tbl_food".
 *
 * The followings are the available columns in table 'tbl_food':
 * @property integer $id
 * @property string $name
 * @property integer $sid
 * @property string $image
 * @property double $price
 * @property string $desc
 * @property integer $status
 * @property string $create_datetime
 * @property string $update_datetime
 */
class Food extends CActiveRecord
{
	const STATUS_NORMAL=1;
	const STATUS_DELETE=-1;
	
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
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_food';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, rid, image, price', 'required'),
			array('sid, rid, rec, sortnum, status', 'numerical', 'integerOnly'=>true),
			array('price, discount', 'numerical'),
			array('name, image, desc, type', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, sid, image, price, desc, rec, sortnum, discount, status, create_datetime, update_datetime, type', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'type' => 'Type',
			'rid' => 'Restaurant',
			'sid' => 'Series',
			'image' => 'Image',
			'price' => 'Price',
			'desc' => 'Desc',
			'rec' => '推荐',
			'sortnum' => '排序',
			'discount' => '打折($)',
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
		$criteria->compare('name',$this->name,true);
//		$criteria->compare('sid',$this->sid);
		$criteria->compare('image',$this->image,true);
//		$criteria->compare('price',$this->price);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('rec',$this->rec);
        if($this->price)
        {
            $criteria->addBetweenCondition('price',$this->price[0],$this->price[1]);
        }
        $criteria->mergeWith($this->dateRangeSearchCriteria('create_datetime', $this->create_datetime));
        $criteria->mergeWith($this->dateRangeSearchCriteria('update_datetime', $this->update_datetime));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'create_datetime DESC',
            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Food the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
