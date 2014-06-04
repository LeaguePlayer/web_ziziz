<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $recall_id
 * @property string $recall_key
 * @property integer $recall_user_id
 * @property integer $recall_datecreate
 * @property integer $recall_lifetime
 */
class Recall extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Recall_keys the static model class
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
		return 'recall_keys';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('recall_key, recall_user_id, recall_date_create, recall_lifetime', 'required'),
			array('recall_key', 'length', 'max'=>300),
            array('recall_id, recall_user_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('recall_id, recall_key, recall_user_id, recall_date_create, recall_lifetime', 'safe', 'on'=>'search'),
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
            'user'=>array(self::BELONGS_TO, 'Users', 'recall_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'recall_id' => 'Key',
			'recall_key' => 'Секретный ключ',
			'recall_user_id' => 'Пользователь',
            'recall_date_create' => 'Время создания ключа',
			'recall_lifetime' => 'Время жизни',
		);
	}
    
    public function validateKey($key)
    {
        //print_r($config);
        return $this->hashKey($key, Yii::app()->params['salt']) === $this->recall_key;
    }
 
    public function hashKey($key, $salt)
    {
        return md5($salt.$key);
    }    
    
    protected function beforeSave()
    {
        if(!empty($this->recall_key))
        {
            $this->recall_key = $this->hashKey($this->recall_key, Yii::app()->params['salt']);
        }
        return parent::beforeSave();
    }
    
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('recall_id',$this->recal_id);
		$criteria->compare('recall_key',$this->recal_key,true);
		$criteria->compare('recall_user_id',$this->recal_user_id,true);
        $criteria->compare('recall_date_create',$this->recall_date_create,true);
		$criteria->compare('recall_lifetime',$this->recall_lifetime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function generateKey()
    {
        $string = 'abcdefghijlklmnopqrstuvwxyzABCDEFGHIJLKLMNOPQRSTUVWXYZ1234567890';
        $result = '';
        $n = strlen($string);
        for ($i=0; $i<10; $i++)
        {
            $result .= $string[rand(0, $n)];
        }
        
        return $result;
    }
}