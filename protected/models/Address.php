<?php

/**
 * This is the model class for table "tbl_address".
 *
 * The followings are the available columns in table 'tbl_address':
 * @property integer $id
 * @property integer $uid
 * @property string $address
 * @property string $format_address
 * @property integer $room
 * @property string $street
 * @property string $locality
 * @property string $region
 * @property integer $zipcode
 */
class Address extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_address';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, address, zipcode', 'required'),
			array('uid, room, zipcode', 'numerical', 'integerOnly'=>true),
			array('address, format_address', 'length', 'max'=>255),
			array('street, locality, region', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, uid, address, format_address, room, street, locality, region, zipcode', 'safe', 'on'=>'search'),
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
			'uid' => 'Uid',
			'address' => 'Address',
			'format_address' => 'Format Address',
			'room' => 'Room',
			'street' => 'Street',
			'locality' => 'Locality',
			'region' => 'Region',
			'zipcode' => 'Zipcode',
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
		$criteria->compare('uid',$this->uid);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('format_address',$this->format_address,true);
		$criteria->compare('room',$this->room);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('locality',$this->locality,true);
		$criteria->compare('region',$this->region,true);
		$criteria->compare('zipcode',$this->zipcode);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public static function getAddressString($data,$default = "")
	{
		if(empty($data)) return "";
		$str = "";
		foreach ($data as $value)
		{
			if($default == $value->id)
			{
				$str .= "<i class='icon-map-marker' style='color:red'></i> ".$value->address."<br>";
			}
			else
			{
				$str .= "<i class='icon-map-marker'></i> ".$value->address."<br>";
			}
		}
		return $str;
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Address the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
