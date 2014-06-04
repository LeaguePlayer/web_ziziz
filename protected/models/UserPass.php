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
class UserPass extends CFormModel
{
    public $user_pass;
    public $new_pass;
	public $compare_pass;
    
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
            array('user_pass, new_pass, compare_pass', 'required'),
            array('user_pass', 'validPass'),
            array('new_pass', 'length', 'max'=>100),
            array('compare_pass', 'compare', 'compareAttribute'=>'new_pass', 'message'=>'Не совпадают пароли'),
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
			'user_pass' => 'Текущий пароль',
			'new_pass' => 'Новый пароль',
			'compare_pass' => 'Подтверждение пароля',
		);
	}
    
    public function validPass($attribute,$params)
    {
        
        $user = Users::model()->findByPk(Yii::app()->user->id);
        //print_r($this->user_pass);die();
        if ($user===null)
            throw new CHttpException(403, 'Не найден пользоваетель');
        
        if ($this->hashPassword($this->user_pass,Yii::app()->params['salt']) === $user->user_pass)
            return true;

        $this->addError('user_pass', 'Пароль неверен');
        return false;
    }
 
    public function hashPassword($password,$salt)
    {
        return md5($salt.$password);
    }
}