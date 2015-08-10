<?php

/**
 * This is the model class for table "tbl_restaurant".
 *
 * The followings are the available columns in table 'tbl_restaurant':
 * @property integer $id
 * @property integer $uid
 * @property string $name
 * @property integer $type
 * @property string $image
 * @property string $tel
 * @property string $mobile
 * @property string $address
 * @property string $map_x
 * @property string $map_y
 * @property string $open_time
 * @property string $close_time
 * @property double $start
 * @property string $area
 * @property integer $zipcode
 * @property integer $vip
 * @property integer $sortnum
 * @property string $tags
 * @property integer $status
 * @property string $create_datetime
 * @property string $update_datetime
 */
class Restaurant extends CActiveRecord
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
		return 'tbl_restaurant';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, name, image, tel, mobile, address, open_time, close_time', 'required'),
			array('uid, type, zipcode, vip, sortnum, status, create_datetime, update_datetime', 'numerical', 'integerOnly'=>true),
			array('uid, name', 'unique'),
			array('start', 'numerical'),
			array('name, address', 'length', 'max'=>200),
			array('image,area,tags', 'length', 'max'=>255),
			array('zipcode', 'length', 'max'=>10),
			array('area,tags', 'commaPadding'),
			array('labels', 'commaPaddingArray'),
			array('labels, tel, mobile, map_x, map_y', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, uid, name, type, image, tel, mobile, address, map_x, map_y, open_time, close_time, start, area, zipcode, vip, labels, sortnum, tags, status, create_datetime, update_datetime', 'safe', 'on'=>'search'),
		);
	}

    /**
     * 给数组字段添加前后逗号
     * @param string $attribute
     * @param array $params
     */
    public function commaPaddingArray($attribute, $params)
    {
        if(!empty($this->$attribute) && is_array($this->$attribute))
        {
            $this->$attribute = ','.implode(",",$this->$attribute).',';
        }
    }
	
	/**
	 * 给字段添加前后逗号
	 * @param string $attribute
	 * @param array $params
	 */
	public function commaPadding($attribute, $params)
	{
		if($this->$attribute)
		{
			$this->$attribute = ','.$this->$attribute.',';
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
				'series'=>array(self::HAS_MANY,'RestaurantSeries','rid'),
				'user'=>array(self::BELONGS_TO,'User','uid'),
				'foods'=>array(self::HAS_MANY,'Food','rid'),
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
			'uid' => '绑定账号',
			'name' => '餐厅名',
			'type' => 'Type',
			'image' => '头像',
			'area' => '送餐区号',
			'start' => '起送价',
			'tel' => '电话',
			'tags' => 'Tags',
			'mobile' => '手机',
			'address' => '地址',
			'map_x' => 'Map X',
			'map_y' => 'Map Y',
			'open_time' => 'Open Time',
			'close_time' => 'Close Time',
			'zipcode' => 'Zipcode',
			'vip' => 'Vip',
			'sortnum' => '排序',
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
		//$criteria->compare('uid',$this->uid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('tel',$this->tel,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('map_x',$this->map_x,true);
		$criteria->compare('map_y',$this->map_y,true);
		$criteria->compare('open_time',$this->open_time,true);
		$criteria->compare('close_time',$this->close_time,true);
		$criteria->compare('start',$this->start);
		$criteria->compare('area',$this->area,true);
		$criteria->compare('zipcode',$this->zipcode);
		$criteria->compare('vip',$this->vip);
		$criteria->compare('sortnum',$this->sortnum);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('status',$this->status);
        if($this->uid) {
            $criteria->join = ' JOIN tbl_user ON tbl_user.id=t.uid';
            $criteria->compare('tbl_user.username', $this->uid, true);
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
	
	public static function getTags($str)
	{
		if(trim($str)==""||trim($str,",")=="") return array();
		$tags = trim($str,",");
		$arr_tags = explode(",", $tags);
		$array = array();
		foreach ($arr_tags as $value)
		{
			$tmp = explode(":", $value);
			$tag = Tag::model()->findByPk($tmp[0]);
			$tag_val = TagValue::model()->findByPk($tmp[1]);
			$name1 = "";
			$name2 = "";
			if($tag)
			{
				$name1 = $tag->name;
			}
			if($tag_val)
			{
				$name2 = $tag_val->value;
			}
			$array[$value] = $name1.":".$name2;
		}
		return $array;
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Restaurant the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
