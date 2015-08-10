<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $firstname
 * @property string $lastname
 * @property string $role
 * @property string $tel
 * @property string $mobile
 * @property integer $address_id
 * @property string $uuid
 * @property string $create_datetime
 * @property string $update_datetime
 */
class User extends CActiveRecord
{
	public $password1;
    public $verifyCode;
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
		return 'tbl_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username', 'required'),
			array('username', 'match', 'allowEmpty'=>false, 'pattern'=>'/^[a-zA-Z][a-zA-Z0-9_]{2,16}$/i','message'=>'用户名由 3-10位的字母下划线和数字组成,不能以数字或下划线开头!'),
			array('password', 'required', 'on'=>'insert'),
			array('username, mobile, email','unique'),
// 			array('password', 'compare', 'compareAttribute'=>'password1','message'=>'两次输入密码不同!'),
			//array('password','md5Password'),
			///array('password', 'compare', 'compareAttribute'=>'password1' ,'on'=>'create'),
			array('address_id, status, token_time, mobile', 'numerical', 'integerOnly'=>true),
			array('username, password, password1, email, uuid, firstname, lastname', 'length', 'max'=>128),
			array('realname', 'length', 'max'=>128),
			array('token', 'length', 'max'=>50),
			array('role, tel, mobile, source', 'length', 'max'=>20),
			array('mobile', 'length', 'is'=>10,'message'=>'手机号长度必须为10位!'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username,realname, password, email, role, tel, mobile, address_id, uuid, create_datetime, update_datetime, source, firstname, lastname, status', 'safe', 'on'=>'search'),
		);
	}
	
	public function md5Password($attribute, $params)
	{
		if($this->$attribute)
		{
			$this->$attribute = md5($this->$attribute);
		}
	}
	
	/**
	 * Returns a list of behaviors that this model should behave as.
	 * @return array
	 */
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
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
				'address'=>array(self::HAS_MANY,"Address","uid"),
				'restaurant'=>array(self::HAS_ONE,"Restaurant","uid"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => '用户名',
			'realname' => '姓名',
			'password' => '密码',
			'password1' => 'Password1',
			'email' => 'Email',
			'firstname' => 'firstname',
			'lastname' => 'lastname',
			'role' => '角色',
			'tel' => '电话',
			'mobile' => '手机号',
			'address_id' => 'Address',
			'source' => '来源',
			'uuid' => 'Uuid',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('tel',$this->tel,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('address_id',$this->address_id);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('uuid',$this->uuid,true);
		$criteria->mergeWith($this->dateRangeSearchCriteria('create_datetime', $this->create_datetime));
		$criteria->mergeWith($this->dateRangeSearchCriteria('update_datetime', $this->update_datetime));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'create_datetime DESC',
            ),
		));
	}

	public function validatePassword($password)
	{
		return $password===$this->password;
	}
	
	public function beforeSave() {
		if(parent::beforeSave())
		{
			
			
			$this->password1 = md5($this->password1);
			 if ($this->isNewRecord) {
				//
				$this->password = md5($this->password);
			} 
			return true;
		}
		return false;
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
