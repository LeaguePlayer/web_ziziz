<?php
class RecoveryForm extends CFormModel
{
    public $key;
    public $email;
    public $pass;
    public $compare_pass;
    public $key_id;
    
   	public function rules()
	{
		return array(
            array('key', 'validateKey'),
            array('pass, compare_pass, key', 'required'),
            array('compare_pass', 'compare', 'compareAttribute'=>'pass', 'message'=>'Не совпадают пароли'),
            array('email', 'safe'),
		);
	}
    
    public function attributeLabels()
	{
		return array(
			'pass' => 'Новый пароль',
            'compare_pass' => 'Подтверждение пароля',
		);
	}
	public function validateKey($attribute, $params)
	{
		$hashKey = md5(Yii::app()->params['salt'].$this->key);
        
		$find = RecoveryKeys::model()->with('user')->find('hash_key=:h_key', array(
            ':h_key'=>$hashKey,
        ));
		if ($find===null){
			$this->addError('key', "Ключ неверен либо удален!");
			return false;
		}
        if ($find->user->user_email <> $this->email){
            $this->addError('key', "Не соответсвует email!");
            return false;
        }
		if (Functions::diffDate(time(), $find->lifetime) < 0){
			$this->addError('key', "Cрок действия ключа истек!");
            $find->delete();
			return false;
		}
        $this->key_id = $find->id;
        
		return true;
	}
}