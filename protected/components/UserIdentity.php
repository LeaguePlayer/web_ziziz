<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    protected $_id;
    
	public function authenticate()
	{
        $username = $this->username;
        
        $user = Users::model()->find('user_login=:login',array(
            ':login'=>$username,
        ));
        if($user === null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if(!$user->validatePassword($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else{
            $this->_id=$user->user_id;
            $this->username=$user->user_login;
            $this->setState('user_id', $user->user_id);
            $this->errorCode=self::ERROR_NONE;
        }
		return !$this->errorCode;
	}
    
    public function getId(){
        
        return $this->_id;
    
    }
}