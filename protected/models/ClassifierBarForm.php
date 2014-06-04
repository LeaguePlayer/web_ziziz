<?php

class ClassifierBarForm extends CFormModel
{
    public function rules()
    {
        return array(array('string', 'required'));
    }
    
    public function safeAttributes()
    {
        return array('string',);
    }

}