<?php

class ClassifierBar extends CWidget
{
    public $cur_category;
    
    public function run()
    {
        $form = new ClassifierBarForm();
        $this->render('classifierBar', array(
            'form'=>$form,
            'cur_category'=>$this->cur_category,
        ));
    }
}