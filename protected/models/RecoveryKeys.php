<?php

/**
 * This is the model class for table "recovery_keys".
 *
 * The followings are the available columns in table 'recovery_keys':
 * @property integer $id
 * @property string $hash_key
 * @property string $date_create
 * @property string $lifetime
 * @property integer $user_id
 */
class RecoveryKeys extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RecoveryKeys the static model class
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
		return 'recovery_keys';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'user'=>array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Key',
			'hash_key' => 'Секретный ключ',
			'user_id' => 'Пользователь',
            'date_create' => 'Время создания ключа',
			'lifetime' => 'Время жизни',
		);
	}
    
    public function validateKey($key)
    {
        return $this->hashKey($key, Yii::app()->params['salt']) === $this->hash_key;
    }
 
    public function hashKey($key, $salt)
    {
        return md5($salt.$key);
    }    
    
    protected function beforeSave()
    {
        if(!empty($this->hash_key))
        {
            $this->hash_key = $this->hashKey($this->hash_key, Yii::app()->params['salt']);
        }
        return parent::beforeSave();
    }
    
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('key',$this->hash_key,true);
		$criteria->compare('user_id',$this->user_id,true);
        $criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('lifetime',$this->lifetime,true);

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