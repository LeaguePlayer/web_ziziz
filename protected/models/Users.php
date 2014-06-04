<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $user_id
 * @property string $user_fio
 * @property string $user_phone
 * @property string $user_email
 * @property string $user_login
 * @property string $user_pass
 * @property string $user_salt
 * @property string $user_role
 * @property string $user_city_id
 */
class Users extends CActiveRecord
{
	const USERTYPE_PHYS_PERSON = 1;
	const USERTYPE_JUR_PERSON = 2;

	public $compare_pass;
    public $user_cityname;
//    
//    public $company_address;
//    public $company_name;
//    public $company_type;
//    public $show_on_map = true;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('user_login', 'required', 'on'=>'step1, step2, step3, force'),
            array('user_email', 'required', 'on'=>'force'),
			array('user_type, user_email, user_fio, user_login, user_pass, user_role, user_cityname', 'required', 'on'=>'step2, step3'),
            array('compare_pass', 'required', 'on'=>'step2'),
			array('user_fio', 'length', 'max'=>200, 'on'=>'step2, update'),
			array('user_phone', 'length', 'max'=>15, 'on'=>'step2, update'),
			array('user_email, user_pass', 'length', 'max'=>100, 'on'=>'step2, force, update'),
            array('user_email', 'email', 'on'=>'step2, force, update'),
			array('user_login', 'length', 'max'=>150, 'on'=>'step2, force, update'),
			array('user_role', 'length', 'max'=>50, 'on'=>'step2, update'),
            array('user_type, user_city_id', 'numerical', 'integerOnly'=>true, 'on'=>'step1, step2, update'),
            array('user_login, user_email', 'unique', 'caseSensitive'=>false, 'on'=>'step2, force, update'),
            array('user_pass', 'compare', 'compareAttribute'=>'compare_pass', 'on'=>'step2'),
            
            array('user_login, user_type, user_email, user_fio, user_login, user_city_id', 'required', 'on'=>'update'),
			
            // The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, user_fio, user_phone, user_email, user_login, user_pass, user_role ,user_type', 'safe', 'on'=>'search'),
            array('email_notice', 'safe', 'on'=>'step2, step3'),
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
			'city'=>array(self::BELONGS_TO, 'Citys', 'user_city_id'),
            'announcements'=>array(self::HAS_MANY, 'Announcements', 'ann_user_id'),
            'annCount'=>array(self::STAT, 'Announcements', 'ann_user_id', 'select'=>'count(*)'),
            'auto'=>array(self::HAS_MANY, 'Auto', 'auto_user'),
            'autoCount'=>array(self::STAT, 'Auto', 'auto_user', 'select'=>'count(*)'),
            'messages'=>array(self::HAS_MANY, 'Messages', 'to'),
            'messagesCount'=>array(self::STAT, 'Messages', 'to', 'select'=>'count(*)'),
            'company'=>array(self::HAS_MANY, 'Company', 'company_user_id'),
            'actions'=>array(self::HAS_MANY, 'Actions', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'user_fio' => 'ФИО',
			'user_phone' => 'Телефон',
			'user_email' => 'Ваш email',
			'user_login' => 'Логин',
			'user_pass' => 'Пароль',
			'user_role' => 'Роль',
            'user_type' => 'Тип',
            'user_city_id' => 'Город',
            'compare_pass' => 'Повторите пароль',
            'email_notice' => 'Отправлять уведомления на email',
            'user_cityname' => 'Город'
		);
	}
    
    public function validatePassword($password)
    {
        return $this->hashPassword($password,Yii::app()->params['salt']) === $this->user_pass;
    }
 
    public function hashPassword($password,$salt)
    {
        //print_r($salt.$password);die();
        return md5($salt.$password);
    }
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
    
    
    protected function beforeSave(){
        if($this->isNewRecord){
            $this->user_pass = $this->hashPassword($this->user_pass, Yii::app()->params['salt']);
        }
        return parent::beforeSave();
    }
    
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_fio',$this->user_fio,true);
		$criteria->compare('user_phone',$this->user_phone,true);
		$criteria->compare('user_email',$this->user_email,true);
		$criteria->compare('user_login',$this->user_login,true);
		$criteria->compare('user_pass',$this->user_pass,true);
		$criteria->compare('user_salt',$this->user_salt,true);
		$criteria->compare('user_role',$this->user_role,true);
        $criteria->compare('user_type',$this->user_role,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function allPostCount()
    {
        return $this->annCount + $this->autoCount;
    }
}