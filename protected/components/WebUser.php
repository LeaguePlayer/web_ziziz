<?php
class WebUser extends CWebUser {
    private $_model = null;
 
    function getRole() {
        if($user = $this->getModel()){
            // � ������� User ���� ���� role
            return $user->user_role;
        }
    }
 
    private function getModel(){
        if (!$this->isGuest && $this->_model === null){
            $this->_model = Users::model()->findByPk($this->id, array('select' => 'user_role'));
        }
        return $this->_model;
    }

    public function getProfileUrl()
    {
        return ( $this->isGuest ) ? '' : Yii::app()->urlManager->createUrl('/users/view', array('id'=>$this->id));
    }
}