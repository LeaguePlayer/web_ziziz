<?php
class RecallForm extends CFormModel
{
    public $email;
    public $user_id;
    
   	public function rules()
	{
		return array(
            array('email', 'required'),
            array('email', 'email'),
            array('email', 'exists'),
		);
	}
    
    /**
     * @param string $attribute имя поля, которое будем валидировать
     * @param array $params дополнительные параметры для правила валидации
     */
    public function exists($attribute, $params) {
        $user = Users::model()->find('user_email=:email', array(':email'=>$this->email));
        if ($user)
        {
            $this->user_id = $user->user_id;
            return true;
        }
        $this->addError('email', 'Не найдено пользователя с таким email');
        return false;
    }
    
    public function attributeLabels()
	{
		return array(
			'email' => 'Ваш email',
		);
	}
}